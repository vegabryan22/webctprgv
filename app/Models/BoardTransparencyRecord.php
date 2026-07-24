<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BoardTransparencyRecord extends Model
{
    protected $fillable = ['author_id', 'title', 'slug', 'type', 'summary', 'content', 'responsible', 'source', 'record_date', 'status', 'verified_at', 'published_at', 'sort_order'];

    protected function casts(): array
    {
        return ['record_date' => 'date', 'verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(InstitutionalDocument::class, 'board_record_document');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('verified_at')->where('published_at', '<=', now());
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'project' => 'Proyecto',
            'process' => 'Proceso',
            'report' => 'Informe',
        };
    }
}
