<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function articles(): HasMany
    {
        return $this->hasMany(NewsArticle::class);
    }
}
