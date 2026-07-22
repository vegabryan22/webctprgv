<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GitOpsEvent extends Model
{
    protected $fillable = [
        'user_id', 'action', 'repository', 'workflow', 'git_ref', 'status', 'message', 'external_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
