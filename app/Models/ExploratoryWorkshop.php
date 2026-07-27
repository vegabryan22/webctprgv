<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExploratoryWorkshop extends Model
{
    protected $fillable = ['author_id', 'name', 'slug', 'grade_level', 'summary', 'description', 'responsible', 'status', 'verified_at', 'published_at', 'sort_order'];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function curricularDocuments(): HasMany
    {
        return $this->hasMany(CurricularDocument::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }
}
