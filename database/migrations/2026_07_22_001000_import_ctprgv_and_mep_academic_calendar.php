<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach ([
            ['Académica', 'academica', '#002f5d'],
            ['Técnica', 'tecnica', '#4cb11d'],
            ['Administrativa', 'administrativa', '#64748b'],
            ['Institucional', 'institucional', '#c59f00'],
        ] as $category) {
            DB::table('event_categories')->insertOrIgnore([
                'name' => $category[0],
                'slug' => $category[1],
                'color' => $category[2],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $categories = DB::table('event_categories')->pluck('id', 'slug');

        foreach ($this->ctprgvEvents() as $event) {
            $this->insert($event, $categories, 'ctprgv', 'Circular DRED-SC07-CTPRGV-D-015-2026', 100);
        }

        foreach ($this->mepAcademicEvents() as $event) {
            $this->insert($event, $categories, 'mep', 'Calendario 2026 del MEP', 20);
        }
    }

    public function down(): void
    {
        DB::table('events')->where('slug', 'like', 'ctprgv-2026-%')->orWhere('slug', 'like', 'mep-acad-2026-%')->delete();
    }

    private function insert(array $event, $categories, string $source, string $reference, int $priority): void
    {
        [$slug, $start, $end, $title, $category, $audience, $page, $description] = $event;
        $allDay = strlen($start) === 10;
        $prefix = $source === 'mep' ? 'mep-acad-2026-' : 'ctprgv-2026-';
        $notice = $source === 'mep'
            ? 'Fecha tentativa de referencia; confirme cualquier cambio con el CTPRGV.'
            : 'Fecha institucional sujeta a cambios por disposiciones ministeriales o situaciones fortuitas.';

        DB::table('events')->insertOrIgnore([
            'event_category_id' => $categories[$category],
            'author_id' => null,
            'title' => $title,
            'slug' => $prefix.$slug,
            'summary' => $notice,
            'description' => $description."\n\nFuente: {$reference}, página {$page}. {$notice}",
            'starts_at' => $allDay ? $start.' 00:00:00' : $start,
            'ends_at' => $end ? (strlen($end) === 10 ? $end.' 23:59:59' : $end) : null,
            'all_day' => $allDay,
            'location' => $source === 'ctprgv' ? 'CTP Roberto Gamboa Valverde' : null,
            'audience' => $audience,
            'status' => 'published',
            'source' => $source,
            'source_reference' => $reference,
            'is_tentative' => true,
            'source_priority' => $priority,
            'published_at' => '2026-07-22 00:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function ctprgvEvents(): array
    {
        return [
            ['i-periodo-duodecimo', '2026-02-23', '2026-06-05', 'I periodo lectivo de duodécimo año', 'academica', 'students', 1, 'Periodo lectivo institucional para duodécimo año.'],
            ['primera-prueba-tecnica-duodecimo-i', '2026-03-16', '2026-03-20', 'Primera prueba técnica de duodécimo — I periodo', 'tecnica', 'students', 1, 'Aplicación sin suspensión de lecciones.'],
            ['diagnostica-nacional-duodecimo', '2026-03-23 07:00:00', '2026-03-27 07:00:00', 'Prueba Nacional Estandarizada Diagnóstica — duodécimo', 'academica', 'students', 1, 'Aplicación para duodécimo año a las 7:00 a. m.'],
            ['semana-santa', '2026-03-29', '2026-04-05', 'Semana Santa', 'institucional', 'general', 1, 'Receso de Semana Santa.'],
            ['primera-prueba-academica-i', '2026-04-13', '2026-04-17', 'Primera prueba académica — I periodo', 'academica', 'students', 1, 'Aplicación con suspensión de lecciones para los niveles indicados en la circular.'],
            ['produccion-texto-escrito', '2026-04-29 07:00:00', null, 'Prueba de producción de texto escrito de secundaria', 'academica', 'students', 1, 'Aplicación a las 7:00 a. m.'],
            ['segunda-prueba-tecnica-duodecimo-i', '2026-05-06', '2026-05-12', 'Segunda prueba técnica de duodécimo — I periodo', 'tecnica', 'students', 1, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-academica-duodecimo-i', '2026-05-13', '2026-05-19', 'Segunda prueba académica de duodécimo — I periodo', 'academica', 'students', 1, 'Aplicación con suspensión de lecciones.'],
            ['reprogramacion-diagnostica-duodecimo', '2026-05-25 07:00:00', '2026-05-29 07:00:00', 'Reprogramación de Prueba Nacional Estandarizada Diagnóstica', 'academica', 'students', 1, 'Reprogramación para duodécimo año a las 7:00 a. m.'],
            ['actas-sea-duodecimo-i', '2026-05-29', null, 'Entrega de actas SEA — duodécimo, I periodo', 'administrativa', 'staff', 1, 'Entrega al auxiliar administrativo.'],
            ['fin-i-periodo-duodecimo', '2026-06-05', null, 'Fin del I periodo lectivo de duodécimo', 'academica', 'general', 1, 'Cierre del primer periodo lectivo para duodécimo año.'],
            ['informes-duodecimo-i', '2026-06-08', '2026-06-10', 'Entrega de informes de calificaciones — duodécimo, I periodo', 'administrativa', 'families', 1, 'Entrega institucional de informes de calificaciones.'],
            ['lengua-extranjera-duodecimo', '2026-06-02 07:00:00', '2026-06-05 07:00:00', 'Prueba Nacional Estandarizada de Lengua Extranjera', 'academica', 'students', 2, 'Aplicación para duodécimo año a las 7:00 a. m.'],
            ['ii-periodo-duodecimo', '2026-06-08', '2026-09-11', 'II periodo lectivo de duodécimo año', 'academica', 'students', 2, 'Segundo periodo lectivo institucional para duodécimo año.'],
            ['primera-prueba-tecnica-duodecimo-ii', '2026-06-11', '2026-06-17', 'Primera prueba técnica de duodécimo — II periodo', 'tecnica', 'students', 2, 'Aplicación sin suspensión de lecciones.'],
            ['primera-prueba-academica-duodecimo-ii', '2026-06-18', '2026-06-23', 'Primera prueba académica de duodécimo — II periodo', 'academica', 'students', 2, 'Aplicación con suspensión de lecciones.'],
            ['vacaciones-medio-periodo', '2026-07-06', '2026-07-17', 'Vacaciones de medio periodo', 'institucional', 'general', 2, 'Receso de medio periodo.'],
            ['segunda-prueba-tecnica-duodecimo-ii', '2026-08-03', '2026-08-06', 'Segunda prueba técnica de duodécimo — II periodo', 'tecnica', 'students', 2, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-academica-duodecimo-ii', '2026-08-17', '2026-08-21', 'Segunda prueba académica de duodécimo — II periodo', 'academica', 'students', 2, 'Aplicación con suspensión de lecciones.'],
            ['actas-sea-duodecimo-ii', '2026-09-01', null, 'Entrega de actas SEA — duodécimo, II periodo', 'administrativa', 'staff', 2, 'Entrega al auxiliar administrativo.'],
            ['reprogramacion-lengua-extranjera', '2026-09-01 07:00:00', '2026-09-04 07:00:00', 'Reprogramación de Prueba Nacional de Lengua Extranjera', 'academica', 'students', 2, 'Aplicación a las 7:00 a. m.'],
            ['primera-ampliacion-duodecimo', '2026-09-07', '2026-09-11', 'Primera prueba de ampliación — duodécimo', 'academica', 'students', 2, 'Primera convocatoria de ampliación 2026.'],
            ['acta-primera-ampliacion-duodecimo', '2026-09-17', null, 'Entrega de acta SEA de primera ampliación — duodécimo', 'administrativa', 'staff', 2, 'Entrega al auxiliar administrativo.'],
            ['sumativa-nacional-duodecimo', '2026-09-21 07:00:00', '2026-09-25 07:00:00', 'Prueba Nacional Estandarizada Sumativa — duodécimo', 'academica', 'students', 2, 'Aplicación a las 7:00 a. m.'],
            ['informes-duodecimo-ii', '2026-09-22', '2026-09-23', 'Entrega de informes de calificaciones — duodécimo, II periodo', 'administrativa', 'families', 2, 'Entrega institucional de informes.'],
            ['comprensiva-especialidades', '2026-10-01 07:00:00', '2026-10-02 07:00:00', 'Prueba Nacional Comprensiva de Especialidades Técnicas', 'tecnica', 'students', 2, 'Aplicación a las 7:00 a. m.'],
            ['practica-profesional-duodecimo', '2026-10-05', '2026-11-27', 'Práctica profesional de duodécimo año', 'tecnica', 'students', 2, 'Periodo institucional de práctica profesional.'],
            ['reprogramacion-sumativa-duodecimo', '2026-11-10 07:00:00', '2026-11-14 07:00:00', 'Reprogramación de Prueba Nacional Estandarizada Sumativa', 'academica', 'students', 2, 'Aplicación a las 7:00 a. m.'],
            ['segunda-ampliacion-noveno-duodecimo', '2026-11-30', '2026-12-04', 'Segunda prueba de ampliación — noveno y duodécimo', 'academica', 'students', 4, 'Segunda convocatoria de ampliación 2026 para noveno y duodécimo.'],
            ['graduacion', '2026-12-10 10:00:00', null, 'Acto de clausura y graduación', 'institucional', 'general', 2, 'Acto institucional a las 10:00 a. m.'],
            ['i-periodo-setimo-undecimo', '2026-02-23', '2026-07-03', 'I periodo lectivo de sétimo a undécimo', 'academica', 'students', 3, 'Primer periodo lectivo para sétimo, octavo, noveno, décimo y undécimo.'],
            ['primera-prueba-tecnica-setimo-undecimo-i', '2026-04-20', '2026-04-24', 'Primera prueba técnica de sétimo a undécimo — I periodo', 'tecnica', 'students', 3, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-tecnica-setimo-undecimo-i', '2026-06-11', '2026-06-17', 'Segunda prueba técnica de sétimo a undécimo — I periodo', 'tecnica', 'students', 3, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-academica-setimo-undecimo-i', '2026-06-18', '2026-06-23', 'Segunda prueba académica de sétimo a undécimo — I periodo', 'academica', 'students', 3, 'Aplicación con suspensión de lecciones.'],
            ['fin-i-periodo-setimo-undecimo', '2026-07-03', null, 'Fin del I periodo de sétimo a undécimo', 'academica', 'general', 3, 'Cierre del primer periodo lectivo.'],
            ['actas-sea-setimo-undecimo-i', '2026-07-23', null, 'Entrega de actas SEA — sétimo a undécimo, I periodo', 'administrativa', 'staff', 3, 'Entrega al auxiliar administrativo.'],
            ['informes-setimo-undecimo-i', '2026-07-30', '2026-07-31', 'Entrega de informes de calificaciones — sétimo a undécimo', 'administrativa', 'families', 3, 'Entrega de informes del primer periodo.'],
            ['ii-periodo-setimo-undecimo', '2026-07-20', '2026-12-09', 'II periodo lectivo de sétimo a undécimo', 'academica', 'students', 3, 'La circular indica “II periodo 2025”; se interpreta como 2026 por el asunto, fecha y secuencia del documento.'],
            ['primera-prueba-tecnica-setimo-undecimo-ii', '2026-08-25', '2026-08-31', 'Primera prueba técnica de sétimo a undécimo — II periodo', 'tecnica', 'students', 3, 'Aplicación sin suspensión de lecciones.'],
            ['primera-prueba-academica-setimo-undecimo-ii', '2026-09-01', '2026-09-07', 'Primera prueba académica de sétimo a undécimo — II periodo', 'academica', 'students', 3, 'Aplicación con suspensión de lecciones.'],
            ['pasantias-undecimo', '2026-09-21', '2026-10-02', 'Pasantías de undécimo año', 'tecnica', 'students', 3, 'Periodo institucional de pasantías.'],
            ['segunda-prueba-tecnica-noveno-ii', '2026-10-01', '2026-10-07', 'Segunda prueba técnica de noveno — II periodo', 'tecnica', 'students', 3, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-academica-noveno-ii', '2026-10-08', '2026-10-14', 'Segunda prueba académica de noveno — II periodo', 'academica', 'students', 3, 'Aplicación con suspensión de lecciones.'],
            ['actas-sea-noveno-ii', '2026-10-27', null, 'Entrega de actas SEA — noveno, II periodo', 'administrativa', 'staff', 3, 'Entrega de actas del segundo periodo.'],
            ['segunda-prueba-tecnica-otros-ii', '2026-10-22', '2026-10-28', 'Segunda prueba técnica de 7.°, 8.°, 10.° y 11.° — II periodo', 'tecnica', 'students', 3, 'Aplicación sin suspensión de lecciones.'],
            ['segunda-prueba-academica-otros-ii', '2026-10-29', '2026-11-05', 'Segunda prueba académica de 7.°, 8.°, 10.° y 11.° — II periodo', 'academica', 'students', 3, 'Aplicación con suspensión de lecciones.'],
            ['primera-ampliacion-noveno', '2026-11-09', '2026-11-13', 'Primera prueba de ampliación — noveno', 'academica', 'students', 3, 'Primera convocatoria de ampliación para noveno año.'],
            ['actas-sea-otros-ii', '2026-11-18', null, 'Entrega de actas SEA — 7.°, 8.°, 10.° y 11.°', 'administrativa', 'staff', 3, 'Entrega de actas del segundo periodo.'],
            ['actas-aplazados-noveno', '2026-11-18', null, 'Entrega de actas de aplazados — noveno', 'administrativa', 'staff', 4, 'Entrega institucional de actas.'],
            ['informes-noveno', '2026-11-26', '2026-11-27', 'Entrega de informes de notas — noveno', 'administrativa', 'families', 4, 'Entrega de informes de calificaciones.'],
            ['primera-ampliacion-otros', '2026-11-30', '2026-12-04', 'Primera prueba de ampliación — 7.°, 8.°, 10.° y 11.°', 'academica', 'students', 4, 'Primera convocatoria de ampliación.'],
            ['informes-otros-ii', '2026-12-03', '2026-12-04', 'Entrega de informes de notas — 7.°, 8.°, 10.° y 11.°', 'administrativa', 'families', 4, 'Entrega de informes de calificaciones.'],
            ['actas-aplazados-todos', '2026-12-08', null, 'Entrega de actas de aplazados — todos los niveles', 'administrativa', 'staff', 4, 'Entrega institucional de actas.'],
            ['entrega-segundas-ampliaciones-direccion', '2026-12-09', null, 'Entrega de II pruebas de ampliación a Dirección', 'administrativa', 'staff', 4, 'Entrega administrativa a la Dirección.'],
            ['cierre-curso-lectivo', '2026-12-09', null, 'Cierre del curso lectivo 2026', 'institucional', 'general', 4, 'Cierre institucional del curso lectivo.'],
            ['certificados-noveno', '2026-12-10 08:00:00', null, 'Entrega de certificados de conclusión de estudios — noveno', 'institucional', 'students', 4, 'Entrega a las 8:00 a. m.'],
        ];
    }

    private function mepAcademicEvents(): array
    {
        return [
            ['inicio-lecciones', '2026-02-23', null, 'Inicio de lecciones 2026', 'academica', 'general', 6, 'Inicio general de lecciones según el calendario ministerial.'],
            ['i-periodo-general', '2026-02-23', '2026-07-03', 'I periodo lectivo 2026', 'academica', 'general', 7, 'Periodo para educación preescolar, general básica, diversificada académica y técnica excepto duodécimo, CINDEA e IPEC.'],
            ['diagnostica-secundaria', '2026-03-23', '2026-03-27', 'Pruebas Nacionales Estandarizadas Diagnósticas de secundaria', 'academica', 'students', 14, 'Aplicación diagnóstica nacional de secundaria.'],
            ['produccion-texto-secundaria', '2026-04-29', null, 'Prueba de producción de texto escrito de secundaria', 'academica', 'students', 22, 'Aplicación nacional de producción de texto escrito.'],
            ['reprogramacion-diagnostica-secundaria', '2026-05-25', '2026-05-29', 'Reprogramación de pruebas diagnósticas de secundaria', 'academica', 'students', 30, 'Reprogramación ministerial de la aplicación diagnóstica.'],
            ['lenguas-extranjeras-ctp', '2026-06-02', '2026-06-05', 'Prueba Nacional Estandarizada de Lenguas Extranjeras — CTP', 'academica', 'students', 32, 'Aplicación para estudiantes de Colegios Técnicos Profesionales.'],
            ['ii-periodo-general', '2026-07-20', '2026-12-09', 'II periodo lectivo 2026', 'academica', 'general', 40, 'Segundo periodo lectivo general según calendario ministerial.'],
            ['reprogramacion-lenguas-extranjeras-ctp', '2026-09-01', '2026-09-04', 'Reprogramación de Lenguas Extranjeras — CTP', 'academica', 'students', 51, 'Reprogramación ministerial para estudiantes de Colegios Técnicos Profesionales.'],
            ['sumativa-ctp', '2026-09-21', '2026-09-25', 'Prueba Nacional Estandarizada Sumativa — CTP', 'academica', 'students', 54, 'Aplicación sumativa para Colegios Técnicos Profesionales.'],
            ['comprensiva-especialidades', '2026-10-01', '2026-10-02', 'Prueba Nacional Comprensiva de Especialidades Técnicas', 'tecnica', 'students', 56, 'Aplicación ministerial de la prueba comprensiva de especialidades.'],
            ['reprogramacion-sumativa-secundaria', '2026-11-09', '2026-11-13', 'Reprogramación de Prueba Nacional Estandarizada Sumativa de secundaria', 'academica', 'students', 63, 'Reprogramación ministerial de la prueba sumativa de secundaria.'],
            ['segunda-ampliacion', '2026-11-30', '2026-12-04', 'II prueba de ampliación de secundaria', 'academica', 'students', 68, 'Aplicación para los niveles y modalidades indicados por el MEP.'],
            ['fin-curso-lectivo', '2026-12-09', null, 'Finalización del curso lectivo 2026', 'institucional', 'general', 70, 'Fecha de cierre del curso lectivo según el calendario ministerial.'],
        ];
    }
};
