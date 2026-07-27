<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurricularDocument extends Model
{
    protected $fillable = [
        'specialty_id',
        'exploratory_workshop_id',
        'title',
        'grade_level',
        'language',
        'file_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(ExploratoryWorkshop::class, 'exploratory_workshop_id');
    }
}
