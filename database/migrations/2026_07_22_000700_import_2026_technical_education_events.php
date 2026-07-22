<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SLUG_PREFIX = 'mep-etp-2026-';

    public function up(): void
    {
        $now = now();

        DB::table('event_categories')->insertOrIgnore([
            'name' => 'Técnica',
            'slug' => 'tecnica',
            'color' => '#4cb11d',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $categoryId = DB::table('event_categories')->where('slug', 'tecnica')->value('id');

        foreach ($this->events() as $event) {
            DB::table('events')->insertOrIgnore([
                'event_category_id' => $categoryId,
                'author_id' => null,
                'title' => $event[3],
                'slug' => self::SLUG_PREFIX.$event[0],
                'summary' => 'Actividad de Educación Técnica del Calendario 2026 del MEP.',
                'description' => $event[4]."\n\nFuente: Calendario 2026 del MEP, página {$event[5]} del PDF.",
                'starts_at' => $event[1].' 00:00:00',
                'ends_at' => $event[2].' 23:59:59',
                'all_day' => true,
                'location' => null,
                'audience' => $event[6],
                'status' => 'published',
                'published_at' => '2026-07-22 00:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('events')->where('slug', 'like', self::SLUG_PREFIX.'%')->delete();
    }

    private function events(): array
    {
        return [
            ['primer-periodo-ultimo-nivel', '2026-02-23', '2026-06-05', 'I periodo lectivo 2026 para el último año de Educación Técnica', 'Primer periodo lectivo para el último nivel de Educación Técnica Profesional impartido en colegios técnicos profesionales, IPEC y CINDEA con carreras técnicas.', 8, 'general'],
            ['fvec8-necesidad-talento-humano', '2026-03-02', '2026-03-31', 'Aplicación del formulario FVEC-8 sobre necesidad de talento humano', 'Aplicación del instrumento de Vinculación con la Empresa y la Comunidad para recopilar necesidades del sector productivo según la oferta de especialidades técnicas.', 9, 'staff'],
            ['practica-rezagados', '2026-03-02', '2026-05-04', 'Práctica supervisada o proyecto de graduación para estudiantes rezagados', 'Periodo para que estudiantes rezagados del último nivel de Educación Técnica Profesional efectúen la práctica supervisada o el proyecto de graduación.', 10, 'students'],
            ['induccion-modalidad-dual', '2026-03-16', '2026-03-20', 'Inducción a la modalidad dual', 'Inducción dirigida a centros educativos interesados en implementar la modalidad dual durante 2027.', 12, 'staff'],
            ['induccion-expotecnica', '2026-03-16', '2026-03-20', 'Inducción a los lineamientos de ExpoTécnica 2026', 'Inducción sobre los lineamientos técnicos y administrativos para implementar ExpoTécnica 2026.', 12, 'staff'],
            ['emprendimiento-cooperativo', '2026-03-23', '2026-03-27', 'Proyecto de Emprendimiento Cooperativo', 'Presentación y promoción del proyecto para escuelas con cooperativa escolar, dirigida a autoridades educativas y docentes con recargo de cooperativismo.', 14, 'staff'],
            ['primera-asamblea-corvec', '2026-04-13', '2026-04-17', 'I Asamblea del Consejo Regional de Vinculación con la Empresa y la Comunidad (CORVEC)', 'Asamblea presencial o virtual para analizar y socializar la oferta educativa 2027 y elegir el Comité Directivo CORVEC.', 17, 'staff'],
            ['racing-steam-regional', '2026-04-20', '2026-04-30', 'Presentación regional de Racing STEAM Fórmula 1 en secundaria', 'Presentación regional de los proyectos de Fórmula 1 en secundaria, categoría Entry Level Handmade Class.', 19, 'students'],
            ['fvec6-duodecimo', '2026-05-20', '2026-05-20', 'Sensibilización y aplicación FVEC-6 a estudiantes de último nivel', 'Sensibilización a estudiantes de 12.° de colegios técnicos y 3.er nivel de IPEC y CINDEA sobre la consulta a personas egresadas FVEC-6.', 28, 'students'],
            ['segundo-periodo-ultimo-nivel', '2026-06-08', '2026-09-04', 'II periodo lectivo 2026 para el último año de Educación Técnica', 'Segundo periodo lectivo para el último nivel de Educación Técnica Profesional impartido en colegios técnicos profesionales, IPEC y CINDEA con carreras técnicas.', 33, 'general'],
            ['racing-steam-final-development', '2026-06-20', '2026-06-21', 'Final nacional Racing STEAM: Development Class', 'Presentación nacional de proyectos de Fórmula 1 en secundaria, categoría Final Development Class.', 36, 'students'],
            ['racing-steam-final-entry', '2026-06-27', '2026-06-28', 'Final nacional Racing STEAM: Entry Level Handmade Class', 'Presentación nacional de proyectos de Fórmula 1 en secundaria, categoría Final Entry Level Handmade Class.', 37, 'students'],
            ['segunda-asamblea-corvec', '2026-07-20', '2026-07-24', 'II Asamblea del Consejo Regional de Vinculación con la Empresa y la Comunidad (CORVEC)', 'Asamblea para analizar y dar seguimiento a los procesos prospectivos por región y sus informes. Cada CORVEC selecciona un día del periodo.', 40, 'staff'],
            ['evaluacion-gerentes-junior-achievement', '2026-07-27', '2026-07-31', 'Evaluación de gerentes de proyectos La Compañía Junior Achievement-MEP', 'Evaluación de estudiantes que se desempeñan como gerentes de proyectos de emprendimiento con la metodología Junior Achievement.', 42, 'students'],
            ['mercadito-cooperativo-institucional', '2026-08-03', '2026-08-14', 'Ferias institucionales de Mercadito Cooperativo', 'Ferias institucionales con participación de proyectos de emprendimiento cooperativo escolar de primaria.', 44, 'general'],
            ['expotecnica-institucional', '2026-08-03', '2026-08-21', 'ExpoTécnica: etapa institucional', 'Ferias estudiantiles de Educación Técnica Profesional en cada institución para seleccionar participantes de la etapa clasificatoria.', 44, 'students'],
            ['ferias-producto-junior-achievement', '2026-08-22', '2026-08-29', 'Ferias del Producto La Compañía Junior Achievement-MEP', 'Presentación y evaluación de proyectos de emprendimiento estudiantil.', 48, 'students'],
            ['primera-prueba-ampliacion', '2026-09-07', '2026-09-11', 'I Prueba de Ampliación del último nivel de Educación Técnica', 'Periodo de aplicación de la primera prueba de ampliación para estudiantes del último nivel de Educación Técnica Profesional.', 51, 'students'],
            ['fvec6-decimo-undecimo', '2026-09-23', '2026-09-24', 'Sensibilización y aplicación FVEC-6 a estudiantes de 10.° y 11.°', 'Sensibilización a futuros egresados de colegios técnicos, IPEC y CINDEA sobre la importancia de responder la consulta FVEC-6.', 55, 'students'],
            ['expotecnica-regional', '2026-10-05', '2026-10-16', 'ExpoTécnica: etapa regional por CORVEC', 'Ferias estudiantiles regionales de Educación Técnica Profesional para seleccionar participantes de la etapa nacional.', 56, 'students'],
            ['practica-ultimo-nivel', '2026-10-05', '2026-11-27', 'Práctica supervisada o proyecto de graduación del último nivel', 'Periodo de práctica supervisada o proyecto de graduación para optar por el título de Técnico Medio.', 57, 'students'],
            ['tercera-asamblea-corvec', '2026-10-19', '2026-10-23', 'III Asamblea del Consejo Regional de Vinculación con la Empresa y la Comunidad (CORVEC)', 'Asamblea regional para analizar la calidad de la ETP y planificar los insumos de los informes 2027 para la oferta educativa 2028.', 60, 'staff'],
            ['mercadito-cooperativo-regional', '2026-10-19', '2026-10-23', 'Ferias regionales de Mercadito Cooperativo', 'Ferias regionales con participación de proyectos de emprendimiento cooperativo escolar de primaria.', 60, 'general'],
            ['expotecnica-nacional', '2026-11-23', '2026-11-27', 'ExpoTécnica: etapa nacional', 'Estudiantes ganadores de las ferias regionales participan en la Feria Nacional de ExpoTécnica.', 66, 'students'],
        ];
    }
};
