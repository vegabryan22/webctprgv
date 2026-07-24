<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Throwable;

class LocalRepositoryInspector
{
    public function inspect(): array
    {
        try {
            return [
                'available' => true,
                'branch' => $this->run(['git', 'branch', '--show-current']),
                'commit' => $this->run(['git', 'rev-parse', '--short', 'HEAD']),
                'commit_full' => $this->run(['git', 'rev-parse', 'HEAD']),
                'message' => $this->run(['git', 'log', '-1', '--pretty=%s']),
                'author' => $this->run(['git', 'log', '-1', '--pretty=%an']),
                'date' => $this->run(['git', 'log', '-1', '--date=iso-strict', '--pretty=%ad']),
                'remote' => $this->run(['git', 'remote', 'get-url', 'origin'], false),
                'clean' => $this->run(['git', 'status', '--porcelain']) === '',
                'commits' => $this->recentCommits(),
            ];
        } catch (Throwable) {
            return [
                'available' => false,
                'branch' => 'No disponible',
                'commit' => '—',
                'commit_full' => '',
                'message' => 'El despliegue no expone un repositorio Git local.',
                'author' => '—',
                'date' => '—',
                'remote' => '',
                'clean' => null,
                'commits' => [],
            ];
        }
    }

    private function recentCommits(): array
    {
        $output = $this->run(['git', 'log', '-8', '--date=short', '--pretty=%h%x09%ad%x09%an%x09%s']);

        return collect(explode("\n", $output))->filter()->map(function (string $line): array {
            [$hash, $date, $author, $message] = array_pad(explode("\t", $line, 4), 4, '');

            return compact('hash', 'date', 'author', 'message');
        })->values()->all();
    }

    private function run(array $command, bool $required = true): string
    {
        $process = new Process($command, base_path());
        $process->setTimeout(5)->run();

        if ($required) {
            $process->mustRun();
        }

        return trim($process->isSuccessful() ? $process->getOutput() : '');
    }
}
