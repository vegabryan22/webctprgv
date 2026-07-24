<?php

namespace App\Services;

use App\Models\GitOpsSetting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GitHubActionsClient
{
    private function setting(): GitOpsSetting
    {
        return GitOpsSetting::current();
    }

    public function isConfigured(): bool
    {
        return filled($this->setting()->repository);
    }

    public function canDispatch(): bool
    {
        return $this->isConfigured() && filled($this->setting()->token) && filled($this->setting()->workflow);
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
            ->post($this->endpoint('/actions/workflows/'.rawurlencode($this->setting()->workflow).'/dispatches'), [
                'ref' => $this->setting()->branch,
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

        return filled($this->setting()->token) ? $request->withToken($this->setting()->token) : $request;
    }

    private function endpoint(string $suffix): string
    {
        $repository = trim((string) $this->setting()->repository, '/');

        if (! preg_match('/^[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+$/', $repository)) {
            throw new RuntimeException('GITHUB_REPOSITORY debe usar el formato propietario/repositorio.');
        }

        return '/repos/'.$repository.$suffix;
    }
}
