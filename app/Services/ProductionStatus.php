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
            'version' => $this->read('VERSION'),
            'commit' => $this->read('DEPLOYED_COMMIT'),
            'ref' => $this->read('DEPLOYED_REF') ?: 'Despliegue anterior',
            'operation' => $this->read('DEPLOYED_OPERATION') ?: 'deploy',
            'deployed_at' => $this->read('DEPLOYED_AT'),
        ];
    }

    private function read(string $file): string
    {
        $path = base_path($file);

        return is_file($path) ? trim((string) file_get_contents($path)) : '';
    }
}
