<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('content_pages')->updateOrInsert(
            ['route_name' => 'admission'],
            [
                'title' => 'Admisión y matrícula 2027',
                'slug' => 'admision-y-matricula',
                'is_system' => true,
                'summary' => 'Información para el ingreso a 7.º y la elección de especialidad de 10.º.',
                'content' => '<p>Consulte el recorrido que corresponde al nivel de ingreso, las fechas comunicadas por el CTPRGV y los documentos oficiales disponibles.</p>',
                'script' => null,
                'status' => 'published',
                'author_id' => null,
                'published_at' => '2026-07-27 00:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('site_sections')->updateOrInsert(
            ['key' => 'admission'],
            [
                'label' => 'Admisión y matrícula',
                'description' => 'Procesos de ingreso a 7.º y elección de especialidad de 10.º',
                'route_name' => 'admission',
                'is_active' => true,
                'sort_order' => 45,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('navigation_items')->updateOrInsert(
            ['route_name' => 'admission'],
            [
                'label' => 'ADMISIÓN',
                'url' => null,
                'sort_order' => 45,
                'is_active' => true,
                'open_in_new_tab' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('document_categories')->updateOrInsert(
            ['slug' => 'admision-matricula'],
            [
                'name' => 'Admisión y matrícula',
                'icon' => 'fa-user-check',
                'sort_order' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $categoryId = DB::table('document_categories')->where('slug', 'admision-matricula')->value('id');

        foreach ($this->documents() as $document) {
            DB::table('institutional_documents')->updateOrInsert(
                ['slug' => $document['slug']],
                array_merge($document, [
                    'document_category_id' => $categoryId,
                    'author_id' => null,
                    'replaced_by_id' => null,
                    'responsible' => 'Dirección del CTP Roberto Gamboa Valverde',
                    'audience' => 'families',
                    'issued_at' => '2026-07-03',
                    'expires_at' => null,
                    'status' => 'published',
                    'verified_at' => '2026-07-03 00:00:00',
                    'published_at' => '2026-07-27 00:00:00',
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('institutional_documents')->whereIn('slug', collect($this->documents())->pluck('slug'))->delete();
        DB::table('document_categories')->where('slug', 'admision-matricula')->whereNotExists(function ($query): void {
            $query->selectRaw('1')->from('institutional_documents')->whereColumn('institutional_documents.document_category_id', 'document_categories.id');
        })->delete();
        DB::table('navigation_items')->where('route_name', 'admission')->delete();
        DB::table('site_sections')->where('key', 'admission')->delete();
        DB::table('content_pages')->where('route_name', 'admission')->delete();
    }

    private function documents(): array
    {
        return [
            [
                'title' => 'Circular de prematrícula de 7.º para el curso lectivo 2027',
                'slug' => 'circular-prematricula-setimo-2027',
                'description' => 'Cronograma y disposiciones para aspirantes que cursan 6.º durante 2026. El portal no reproduce los montos ni el año del informe que aparecen de forma contradictoria dentro de la circular.',
                'file_path' => 'public:documentos/admision/circular-prematricula-setimo-2027.pdf',
                'original_filename' => 'CIRCULAR DRED-SCE07-CTPRGV-D-206-2026.pdf',
                'version' => 'DRED-SCE07-CTPRGV-D-206-2026',
                'sort_order' => 10,
            ],
            [
                'title' => 'Circular sobre el Reglamento de Admisión y Matrícula',
                'slug' => 'circular-reglamento-admision-2027',
                'description' => 'Comunicación institucional que socializa el reglamento aplicable a los procesos de ingreso de 7.º y 10.º para el curso lectivo 2027.',
                'file_path' => 'public:documentos/admision/circular-reglamento-admision-2027.pdf',
                'original_filename' => 'CIRCULAR DRED-SC07-CTPRGV-D-207-2026.pdf',
                'version' => 'DRED-SC07-CTPRGV-D-207-2026',
                'sort_order' => 20,
            ],
            [
                'title' => 'Reglamento de Admisión y Matrícula para el curso lectivo 2027',
                'slug' => 'reglamento-admision-matricula-2027',
                'description' => 'Texto normativo completo. La disposición final establece su aplicación al curso lectivo 2027; la portada conserva la leyenda 2025-2026 del archivo recibido.',
                'file_path' => 'public:documentos/admision/reglamento-admision-matricula-2027.pdf',
                'original_filename' => 'Reglamento_de_Matricula_CTPRGV_2026_2027.pdf',
                'version' => 'Rige desde junio de 2026',
                'sort_order' => 30,
            ],
        ];
    }
};
