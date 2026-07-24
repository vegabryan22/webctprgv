<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specialty extends Model
{
    protected $fillable = [
        'author_id', 'name', 'slug', 'summary', 'description', 'student_profile', 'curriculum',
        'career_opportunities', 'official_program_url', 'coordinator', 'contact_email', 'image_path',
        'status', 'verified_at', 'published_at', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
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
