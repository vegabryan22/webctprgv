<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GitHubActionsClient
{
    public function isConfigured(): bool
    {
        return filled(config('gitops.repository'));
    }

    public function canDispatch(): bool
    {
        return $this->isConfigured() && filled(config('gitops.token')) && filled(config('gitops.workflow'));
    }

    public function workflowRuns(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        return $this->request()
            ->get($this->endpoint('/actions/runs'), ['per_page' => 8])
            ->throw()
            ->json('workflow_runs', []);
    }

    public function dispatch(): array
    {
        if (! $this->canDispatch()) {
            throw new RuntimeException('La integración de despliegue no está configurada completamente.');
        }

        $response = $this->request()
            ->post($this->endpoint('/actions/workflows/'.rawurlencode(config('gitops.workflow')).'/dispatches'), [
                'ref' => config('gitops.branch'),
            ])
            ->throw();

        return $response->json() ?? [];
    }

    private function request(): PendingRequest
    {
        $request = Http::baseUrl(rtrim(config('gitops.api_url'), '/'))
            ->acceptJson()
            ->withHeaders([
                'X-GitHub-Api-Version' => config('gitops.api_version'),
                'User-Agent' => 'CTPRGV-GitOps',
            ])
            ->timeout(8);

        return filled(config('gitops.token')) ? $request->withToken(config('gitops.token')) : $request;
    }

    private function endpoint(string $suffix): string
    {
        $repository = trim((string) config('gitops.repository'), '/');

        if (! preg_match('/^[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+$/', $repository)) {
            throw new RuntimeException('GITHUB_REPOSITORY debe usar el formato propietario/repositorio.');
        }

        return '/repos/'.$repository.$suffix;
    }
}
