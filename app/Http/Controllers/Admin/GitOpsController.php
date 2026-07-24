<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GitOpsEvent;
use App\Models\GitOpsSetting;
use App\Services\GitHubActionsClient;
use App\Services\LocalRepositoryStatus;
use App\Services\ProductionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class GitOpsController extends Controller
{
    public function index(Request $request, GitHubActionsClient $github, ProductionStatus $production, LocalRepositoryStatus $localRepository): View
    {
        $isDevelopment = app()->environment(['local', 'development']);
        $data = ['runs' => [], 'commits' => [], 'tags' => [], 'runners' => [], 'remote' => []];
        $integrationError = null;

        try {
            $data['runs'] = $github->workflowRuns();
            $data['commits'] = $github->commits();
            $data['tags'] = $github->tags();
            $data['runners'] = $github->runners();
            $data['remote'] = $github->repository();
        } catch (Throwable $exception) {
            report($exception);
            $integrationError = 'No fue posible consultar toda la información de GitHub.';
        }

        $productionStatus = $production->inspect();
        $productionVersion = ltrim((string) $productionStatus['version'], 'v');
        $availableTags = collect($data['tags'])
            ->filter(fn (array $tag) => preg_match('/^v\d+\.\d+\.\d+$/', $tag['name'] ?? ''))
            ->filter(fn (array $tag) => version_compare(ltrim($tag['name'], 'v'), $productionVersion, '>'))
            ->sortBy(fn (array $tag) => ltrim($tag['name'], 'v'), SORT_NATURAL)
            ->values();

        return view('admin.gitops.index', $data + [
            'production' => $productionStatus,
            'availableTags' => $availableTags,
            'latestTag' => $availableTags->last(),
            'integrationError' => $integrationError,
            'configured' => $github->isConfigured(),
            'canDispatch' => $github->canDispatch(),
            'events' => GitOpsEvent::with('user')->latest()->limit(20)->get(),
            'settings' => GitOpsSetting::current(),
            'localRepository' => $isDevelopment ? $localRepository->inspect() : null,
            'isDevelopment' => $isDevelopment,
            'monitoring' => $request->integer('monitor_until') > now()->timestamp,
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'repository' => ['required', 'regex:/^[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+$/', 'max:255'],
            'branch' => ['required', 'regex:/^[A-Za-z0-9._\/-]+$/', 'max:255'],
            'workflow' => ['required', 'regex:/^[A-Za-z0-9._\/-]+\.ya?ml$/', 'max:255'],
            'token' => ['nullable', 'string', 'max:500'],
            'remove_token' => ['nullable', 'boolean'],
        ]);

        $settings = GitOpsSetting::current();
        $settings->fill(collect($data)->only(['repository', 'branch', 'workflow'])->all());
        if ($request->boolean('remove_token')) {
            $settings->token = null;
        } elseif (filled($data['token'] ?? null)) {
            $settings->token = $data['token'];
        }
        $settings->save();

        return back()->with('success', 'Configuración GitOps actualizada de forma segura.');
    }

    public function dispatch(Request $request, GitHubActionsClient $github): RedirectResponse
    {
        $settings = GitOpsSetting::current();
        $data = $request->validate([
            'target_ref' => ['required', 'regex:/^(?:v\d+\.\d+\.\d+|[A-Za-z0-9._\/-]+)$/'],
        ], ['target_ref.required' => 'Seleccione la versión que desea aplicar.']);

        try {
            $allowed = collect($github->tags())->pluck('name')->push($settings->branch);
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors(['gitops' => 'No fue posible verificar la versión seleccionada con GitHub.']);
        }

        if (! $allowed->contains($data['target_ref'])) {
            return back()->withErrors(['target_ref' => 'La versión seleccionada no existe en el repositorio remoto.']);
        }

        return $this->requestDeployment($request, $github, $data['target_ref'], 'deploy');
    }

    public function rollback(Request $request, GitHubActionsClient $github): RedirectResponse
    {
        $data = $request->validate([
            'target_ref' => ['required', 'regex:/^v\d+\.\d+\.\d+$/'],
            'confirmation' => ['required', 'in:REVERTIR'],
        ], [
            'target_ref.regex' => 'Seleccione una versión publicada válida.',
            'confirmation.in' => 'Escriba REVERTIR para confirmar.',
        ]);

        return $this->requestDeployment($request, $github, $data['target_ref'], 'rollback');
    }

    public function cancel(Request $request, GitHubActionsClient $github, int $runId): RedirectResponse
    {
        try {
            $github->cancel($runId);
            GitOpsEvent::create([
                'user_id' => $request->user()->id, 'action' => 'workflow_cancel',
                'repository' => GitOpsSetting::current()->repository, 'status' => 'accepted',
                'message' => "Cancelación solicitada para la ejecución {$runId}.",
            ]);

            return back()->with('success', 'Cancelación solicitada correctamente.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors(['gitops' => 'No fue posible cancelar la ejecución.']);
        }
    }

    public function validateProduction(Request $request, ProductionStatus $production): RedirectResponse
    {
        $status = $production->inspect();
        $ok = $status['http'] === 200 && $status['database'];
        GitOpsEvent::create([
            'user_id' => $request->user()->id, 'action' => 'production_validate',
            'repository' => GitOpsSetting::current()->repository, 'git_ref' => $status['ref'],
            'status' => $ok ? 'ok' : 'failed',
            'message' => "{$status['environment']} · HTTP {$status['http']} · BD ".($status['database'] ? 'OK' : 'ERROR')." · {$status['latency_ms']} ms",
        ]);

        return back()->with(
            $ok ? 'success' : 'error',
            $ok ? "{$status['environment']} validado correctamente." : "La validación de {$status['environment']} detectó errores.",
        );
    }

    private function requestDeployment(Request $request, GitHubActionsClient $github, string $target, string $operation): RedirectResponse
    {
        $event = [
            'user_id' => $request->user()->id, 'action' => $operation === 'rollback' ? 'rollback_dispatch' : 'workflow_dispatch',
            'repository' => GitOpsSetting::current()->repository, 'workflow' => GitOpsSetting::current()->workflow,
            'git_ref' => $target,
        ];

        try {
            $github->dispatch($target, $operation);
            GitOpsEvent::create($event + [
                'status' => 'accepted',
                'message' => $operation === 'rollback' ? "Reversión solicitada a {$target}." : "Despliegue solicitado para {$target}.",
            ]);

            return redirect()->route('admin.gitops.index', [
                'monitor_until' => now()->addMinutes(2)->timestamp,
            ])->with(
                'success',
                $operation === 'rollback'
                    ? "La reversión a {$target} fue solicitada. El estado se actualizará automáticamente."
                    : "El despliegue de {$target} fue solicitado. El estado se actualizará automáticamente.",
            );
        } catch (Throwable $exception) {
            report($exception);
            GitOpsEvent::create($event + ['status' => 'failed', 'message' => $exception->getMessage()]);

            return back()->withErrors(['gitops' => 'GitHub rechazó la operación: '.$exception->getMessage()]);
        }
    }
}
