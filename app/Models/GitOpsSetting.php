<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GitOpsSetting extends Model
{
    protected $fillable = ['repository', 'branch', 'workflow', 'token'];

    protected function casts(): array
    {
        return ['token' => 'encrypted'];
    }

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'repository' => config('gitops.repository'),
            'branch' => config('gitops.branch', 'main'),
            'workflow' => config('gitops.workflow', 'deploy.yml'),
            'token' => config('gitops.token'),
        ]);
    }
}
