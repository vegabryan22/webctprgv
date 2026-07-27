<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('board_transparency_records', function (Blueprint $table): void {
            $table->string('type', 30)->change();
            $table->decimal('price', 12, 2)->nullable()->after('content');
            $table->string('price_note')->nullable()->after('price');
            $table->date('valid_until')->nullable()->after('record_date');
        });

        $page = DB::table('content_pages')->where('route_name', 'board')->first();
        if ($page && str_contains($page->content, 'Licitación #CTPRGV-2025-003')) {
            DB::table('content_pages')->where('id', $page->id)->update([
                'summary' => 'Información verificada sobre la Junta Administrativa, sus proyectos, contrataciones, uniformes y materiales.',
                'content' => '<section class="board-intro-card"><span>Gestión y servicio</span><h2>Información de la Junta Administrativa</h2><p>Consulte publicaciones verificadas sobre productos disponibles, proyectos, contrataciones e informes. Los precios, fechas y condiciones se mostrarán únicamente cuando hayan sido confirmados por la Junta Administrativa.</p></section>',
                'updated_at' => now(),
            ]);
        }

        $records = [
            [
                'title' => 'Camisas del uniforme',
                'slug' => 'camisas-del-uniforme',
                'type' => 'uniform',
                'summary' => 'La Junta Administrativa ofrece camisas del uniforme institucional.',
                'price_note' => 'Precio pendiente de confirmación',
                'sort_order' => 10,
            ],
            [
                'title' => 'Cuaderno de comunicaciones',
                'slug' => 'cuaderno-de-comunicaciones',
                'type' => 'material',
                'summary' => 'La Junta Administrativa ofrece el cuaderno de comunicaciones institucional.',
                'price_note' => 'Precio pendiente de confirmación',
                'sort_order' => 20,
            ],
        ];

        foreach ($records as $record) {
            DB::table('board_transparency_records')->updateOrInsert(
                ['slug' => $record['slug']],
                [
                    ...$record,
                    'responsible' => 'Junta Administrativa',
                    'source' => 'Información institucional confirmada el 27/07/2026',
                    'record_date' => '2026-07-27',
                    'status' => 'published',
                    'verified_at' => now(),
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }

    public function down(): void
    {
        DB::table('board_transparency_records')->whereIn('slug', [
            'camisas-del-uniforme',
            'cuaderno-de-comunicaciones',
        ])->delete();

        Schema::table('board_transparency_records', function (Blueprint $table): void {
            $table->dropColumn(['price', 'price_note', 'valid_until']);
        });
    }
};
