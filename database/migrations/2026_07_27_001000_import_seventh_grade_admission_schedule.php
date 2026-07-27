<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SOURCE = 'Circular DRED-SCE07-CTPRGV-D-206-2026';

    public function up(): void
    {
        $now = now();

        DB::table('event_categories')->updateOrInsert(
            ['slug' => 'admision'],
            [
                'name' => 'Admisión',
                'color' => '#8b5cf6',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $categoryId = DB::table('event_categories')->where('slug', 'admision')->value('id');

        foreach ($this->events() as $event) {
            DB::table('events')->updateOrInsert(
                ['slug' => $event['slug']],
                array_merge($event, [
                    'event_category_id' => $categoryId,
                    'author_id' => null,
                    'location' => 'CTP Roberto Gamboa Valverde',
                    'audience' => 'families',
                    'status' => 'published',
                    'source' => 'ctprgv',
                    'source_reference' => self::SOURCE,
                    'is_tentative' => true,
                    'source_priority' => 110,
                    'published_at' => '2026-07-27 00:00:00',
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('events')->where('slug', 'like', 'ctprgv-admision-2027-%')->delete();

        $categoryId = DB::table('event_categories')->where('slug', 'admision')->value('id');
        if ($categoryId && ! DB::table('events')->where('event_category_id', $categoryId)->exists()) {
            DB::table('event_categories')->where('id', $categoryId)->delete();
        }
    }

    private function events(): array
    {
        $notice = 'Fecha institucional para aspirantes a 7.º del curso lectivo 2027. Puede cambiar mediante una comunicación oficial posterior.';

        return [
            [
                'title' => 'Entrega de insumos de prematrícula de 7.º',
                'slug' => 'ctprgv-admision-2027-insumos-prematricula',
                'summary' => 'Disponibilidad del sobre con los insumos de prematrícula.',
                'description' => "Del 28 al 30 de julio, de 8:00 a. m. a 11:20 a. m., en la oficina de la Junta Administrativa.\n\nFuente: ".self::SOURCE.", página 1. {$notice}",
                'starts_at' => '2026-07-28 08:00:00',
                'ends_at' => '2026-07-30 11:20:00',
                'all_day' => false,
            ],
            [
                'title' => 'Recepción de documentos de prematrícula de 7.º',
                'slug' => 'ctprgv-admision-2027-recepcion-documentos',
                'summary' => 'Recepción de documentos de aspirantes que cursan 6.º durante 2026.',
                'description' => "Los días 5 y 6 de agosto, de 8:00 a. m. a 11:20 a. m. Los requisitos completos deben consultarse en la circular oficial.\n\nFuente: ".self::SOURCE.", página 1. {$notice}",
                'starts_at' => '2026-08-05 08:00:00',
                'ends_at' => '2026-08-06 11:20:00',
                'all_day' => false,
            ],
            [
                'title' => 'Atención de casos justificados de prematrícula de 7.º',
                'slug' => 'ctprgv-admision-2027-casos-justificados',
                'summary' => 'Atención de personas que no pudieron entregar documentos el 5 o 6 de agosto y presentan justificación.',
                'description' => "Atención el 7 de agosto, de 8:00 a. m. a 11:20 a. m., únicamente para casos debidamente justificados.\n\nFuente: ".self::SOURCE.", página 1. {$notice}",
                'starts_at' => '2026-08-07 08:00:00',
                'ends_at' => '2026-08-07 11:20:00',
                'all_day' => false,
            ],
            [
                'title' => 'Prueba de admisión para 7.º',
                'slug' => 'ctprgv-admision-2027-prueba',
                'summary' => 'Aplicación para aspirantes inscritos que entregaron toda la documentación requerida.',
                'description' => "Aplicación el 17 de setiembre, de 7:30 a. m. a 10:00 a. m. Las indicaciones de la prueba serán comunicadas mediante una circular posterior.\n\nFuente: ".self::SOURCE.", página 2. {$notice}",
                'starts_at' => '2026-09-17 07:30:00',
                'ends_at' => '2026-09-17 10:00:00',
                'all_day' => false,
            ],
            [
                'title' => 'Análisis del proceso de admisión de 7.º',
                'slug' => 'ctprgv-admision-2027-analisis',
                'summary' => 'Periodo institucional de análisis y definición del corte de admisión.',
                'description' => "Del 18 de setiembre al 21 de octubre, el Comité de Matrícula analizará los datos y establecerá el corte de admisión.\n\nFuente: ".self::SOURCE.", página 2. {$notice}",
                'starts_at' => '2026-09-18 00:00:00',
                'ends_at' => '2026-10-21 23:59:59',
                'all_day' => true,
            ],
            [
                'title' => 'Publicación de personas admitidas en 7.º',
                'slug' => 'ctprgv-admision-2027-resultados',
                'summary' => 'Exhibición institucional de la lista de personas admitidas para el curso lectivo 2027.',
                'description' => "El 23 de octubre a partir de las 10:00 a. m. La lista se exhibirá en la Dirección mediante números de identificación y no será publicada en Facebook.\n\nFuente: ".self::SOURCE.", página 2. {$notice}",
                'starts_at' => '2026-10-23 10:00:00',
                'ends_at' => null,
                'all_day' => false,
            ],
            [
                'title' => 'Ratificación de matrícula de 7.º para 2027',
                'slug' => 'ctprgv-admision-2027-ratificacion',
                'summary' => 'Periodo obligatorio para las personas admitidas; el día específico será comunicado posteriormente.',
                'description' => "Periodo general del 3 al 8 de diciembre. El CTPRGV comunicará posteriormente el día específico mediante una circular oficial.\n\nFuente: ".self::SOURCE.", página 2. {$notice}",
                'starts_at' => '2026-12-03 00:00:00',
                'ends_at' => '2026-12-08 23:59:59',
                'all_day' => true,
            ],
        ];
    }
};
