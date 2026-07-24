<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DirectoryEntry extends Model
{
    protected $fillable = ['department', 'position', 'person_name', 'phone', 'extension', 'email', 'schedule', 'notes', 'status', 'verified_at', 'published_at', 'sort_order'];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }
}
