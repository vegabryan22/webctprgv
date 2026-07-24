<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Throwable;

class LocalRepositoryStatus
{
    public function inspect(): array
    {
        try {
            $branch = $this->git(['branch', '--show-current']);
            $commit = $this->git(['rev-parse', '--short=8', 'HEAD']);
            $changes = array_values(array_filter(explode("\n", $this->git(['status', '--short']))));
            $tags = array_values(array_filter(explode("\n", $this->git(['tag', '--sort=-v:refname']))));
            $commits = array_values(array_filter(explode("\n", $this->git(['log', '-8', '--pretty=format:%h|%s|%cI']))));
            [$behind, $ahead] = $this->aheadBehind($branch);

            return compact('branch', 'commit', 'changes', 'tags', 'commits', 'ahead', 'behind') + [
                'available' => true,
                'path' => base_path(),
            ];
        } catch (Throwable) {
            return [
                'available' => false, 'path' => base_path(), 'branch' => null, 'commit' => null,
                'changes' => [], 'tags' => [], 'commits' => [], 'ahead' => null, 'behind' => null,
            ];
        }
    }

    private function aheadBehind(string $branch): array
    {
        if ($branch === '') {
            return [null, null];
        }

        try {
            $counts = preg_split('/\s+/', trim($this->git(['rev-list', '--left-right', '--count', "origin/{$branch}...{$branch}"])));

            return [(int) ($counts[0] ?? 0), (int) ($counts[1] ?? 0)];
        } catch (Throwable) {
            return [null, null];
        }
    }

    private function git(array $arguments): string
    {
        $process = new Process(['git', ...$arguments], base_path());
        $process->setTimeout(5);
        $process->mustRun();

        return trim($process->getOutput());
    }
}
