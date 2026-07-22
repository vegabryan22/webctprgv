<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('content_pages')
            ->where('status', 'published')
            ->where('published_at', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->update([
                'published_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            ]);
    }

    public function down(): void
    {
        // La fecha anterior no puede reconstruirse con seguridad.
    }
};
