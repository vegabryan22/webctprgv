<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProfessionalExperience extends Model
{
    protected $fillable = [
        'author_id', 'title', 'slug', 'type', 'summary', 'description', 'requirements', 'process_stages',
        'responsible', 'contact_email', 'company_contact_email', 'duration', 'schedule', 'status',
        'verified_at', 'published_at', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class);
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(InstitutionalDocument::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('verified_at')->where('published_at', '<=', now());
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'professional_practice' => 'Práctica profesional',
            'internship' => 'Pasantía',
            'technical_visit' => 'Visita técnica',
        };
    }
}
