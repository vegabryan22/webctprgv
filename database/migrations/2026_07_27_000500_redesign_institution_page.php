<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('content_pages')->where('route_name', 'information')->first();

        if (! $page || ! str_contains($page->content, 'Información Académica')) {
            return;
        }

        $source = file_get_contents(resource_path('views/public/information.blade.php'));
        preg_match("/@section\('content'\)\s*(.*?)\s*@endsection/s", $source, $content);

        DB::table('content_pages')->where('id', $page->id)->update([
            'title' => 'Nuestra institución',
            'content' => $content[1] ?? $page->content,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // El contenido editorial no se revierte automáticamente para evitar pérdida de ediciones posteriores.
    }
};
