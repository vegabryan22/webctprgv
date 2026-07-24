<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardMember extends Model
{
    protected $fillable = ['author_id', 'name', 'position', 'term_starts_at', 'term_ends_at', 'source', 'status', 'verified_at', 'published_at', 'sort_order'];

    protected function casts(): array
    {
        return ['term_starts_at' => 'date', 'term_ends_at' => 'date', 'verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('verified_at')->where('published_at', '<=', now())
            ->where(fn ($query) => $query->whereNull('term_ends_at')->orWhere('term_ends_at', '>=', today()));
    }
}
