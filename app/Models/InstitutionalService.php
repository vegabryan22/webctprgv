<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionalService extends Model
{
    protected $fillable = [
        'service_category_id', 'author_id', 'name', 'slug', 'summary', 'description', 'requirements',
        'audience', 'responsible', 'schedule', 'email', 'phone', 'external_url', 'attachment_path',
        'status', 'verified_at', 'published_at', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }
}
