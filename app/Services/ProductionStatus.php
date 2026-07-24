<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ProductionStatus
{
    public function inspect(): array
    {
        $started = microtime(true);
        $http = 0;

        try {
            $http = Http::timeout(5)->get(config('gitops.health_url'))->status();
        } catch (Throwable) {
        }

        $database = false;
        try {
            DB::select('select 1');
            $database = true;
        } catch (Throwable) {
        }

        return [
            'http' => $http,
            'latency_ms' => (int) ((microtime(true) - $started) * 1000),
            'database' => $database,
            'version' => trim((string) @file_get_contents(base_path('VERSION'))),
            'commit' => trim((string) @file_get_contents(base_path('DEPLOYED_COMMIT'))),
            'ref' => trim((string) @file_get_contents(base_path('DEPLOYED_REF'))) ?: 'Despliegue anterior',
            'operation' => trim((string) @file_get_contents(base_path('DEPLOYED_OPERATION'))) ?: 'deploy',
            'deployed_at' => trim((string) @file_get_contents(base_path('DEPLOYED_AT'))),
        ];
    }
}
