<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GitOpsEvent;
use App\Models\GitOpsSetting;
use App\Services\GitHubActionsClient;
use App\Services\LocalRepositoryInspector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class GitOpsController extends Controller
{
    public function index(LocalRepositoryInspector $repository, GitHubActionsClient $github): View
    {
        $integrationError = null;
        $runs = [];

        try {
            $runs = $github->workflowRuns();
        } catch (Throwable $exception) {
            report($exception);
            $integrationError = 'No fue posible consultar GitHub. Revise el repositorio, token y conectividad.';
        }

        return view('admin.gitops.index', [
            'repository' => $repository->inspect(),
            'runs' => $runs,
            'integrationError' => $integrationError,
            'configured' => $github->isConfigured(),
            'canDispatch' => $github->canDispatch(),
            'events' => GitOpsEvent::with('user')->latest()->limit(10)->get(),
            'settings' => GitOpsSetting::current(),
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
        ], [
            'repository.regex' => 'Use el formato propietario/repositorio.',
            'workflow.regex' => 'Indique un archivo workflow .yml o .yaml.',
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
        $event = [
            'user_id' => $request->user()->id,
            'action' => 'workflow_dispatch',
            'repository' => GitOpsSetting::current()->repository,
            'workflow' => GitOpsSetting::current()->workflow,
            'git_ref' => GitOpsSetting::current()->branch,
        ];

        try {
            $response = $github->dispatch();
            GitOpsEvent::create($event + [
                'status' => 'accepted',
                'message' => 'GitHub aceptó la solicitud de despliegue.',
                'external_url' => $response['html_url'] ?? null,
            ]);

            return back()->with('success', 'El workflow de despliegue fue solicitado correctamente.');
        } catch (Throwable $exception) {
            report($exception);
            GitOpsEvent::create($event + ['status' => 'failed', 'message' => $exception->getMessage()]);

            return back()->withErrors(['gitops' => 'GitHub rechazó la solicitud. Revise la configuración y los permisos del token.']);
        }
    }
}
