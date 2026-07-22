<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GitOpsEvent;
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
        ]);
    }

    public function dispatch(Request $request, GitHubActionsClient $github): RedirectResponse
    {
        $event = [
            'user_id' => $request->user()->id,
            'action' => 'workflow_dispatch',
            'repository' => config('gitops.repository'),
            'workflow' => config('gitops.workflow'),
            'git_ref' => config('gitops.branch'),
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
