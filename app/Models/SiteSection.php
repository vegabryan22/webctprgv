<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $fillable = ['key', 'label', 'description', 'route_name', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'sort_order' => 'integer'];
    }

    public static function enabled(string $key): bool
    {
        return static::where('key', $key)->value('is_active') ?? true;
    }

    public static function keyForRoute(?string $routeName): ?string
    {
        return match ($routeName) {
            'news' => 'news',
            'information' => 'institution',
            'specialties' => 'specialties',
            'workshops' => 'workshops',
            'board' => 'board',
            'contact' => 'contact',
            'calendar.index' => 'calendar',
            'services.index' => 'services',
            'experiences.index' => 'practice',
            'directory' => 'directory',
            'documents' => 'documents',
            'anniversary' => 'anniversary',
            default => null,
        };
    }
}
