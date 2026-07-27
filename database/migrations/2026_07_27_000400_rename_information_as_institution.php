<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('navigation_items')
            ->where('route_name', 'information')
            ->where('label', 'INFORMACIÓN')
            ->update(['label' => 'INSTITUCIÓN', 'updated_at' => now()]);

        DB::table('content_pages')
            ->where('route_name', 'information')
            ->where('title', 'Información')
            ->update(['title' => 'Nuestra institución', 'updated_at' => now()]);
    }

    public function down(): void
    {
        // Los títulos editoriales no se revierten automáticamente para preservar cambios posteriores.
    }
};
