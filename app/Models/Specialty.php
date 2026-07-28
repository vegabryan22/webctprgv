<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialty extends Model
{
    protected $fillable = [
        'author_id', 'name', 'slug', 'summary', 'grade_levels', 'description', 'student_profile', 'curriculum',
        'career_opportunities', 'official_program_url', 'coordinator', 'contact_email', 'image_path',
        'status', 'is_active', 'verified_at', 'published_at', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function curricularDocuments(): HasMany
    {
        return $this->hasMany(CurricularDocument::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->published()->where('is_active', true);
    }
}
