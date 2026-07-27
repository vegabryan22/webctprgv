<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class InstitutionalDocument extends Model
{
    protected $fillable = ['document_category_id', 'author_id', 'replaced_by_id', 'title', 'slug', 'description', 'file_path', 'original_filename', 'version', 'responsible', 'audience', 'issued_at', 'expires_at', 'status', 'verified_at', 'published_at', 'sort_order'];

    protected function casts(): array
    {
        return ['issued_at' => 'date', 'expires_at' => 'date', 'verified_at' => 'datetime', 'published_at' => 'datetime', 'sort_order' => 'integer'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function replacement(): BelongsTo
    {
        return $this->belongsTo(self::class, 'replaced_by_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->where('published_at', '<=', now())->whereNull('replaced_by_id')->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>=', today()));
    }

    public function publicUrl(): string
    {
        if (str_starts_with($this->file_path, 'public:')) {
            return asset(substr($this->file_path, 7));
        }

        return Storage::disk('public')->url($this->file_path);
    }

    public function isBundledFile(): bool
    {
        return str_starts_with($this->file_path, 'public:');
    }
}
