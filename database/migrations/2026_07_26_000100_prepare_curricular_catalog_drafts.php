<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $specialties = [
            [
                'aliases' => ['Ejecutivo para Centros de Servicio'],
                'name' => 'Ejecutivo comercial y de servicio al cliente',
                'summary' => 'Formación comercial, administrativa y de servicio al cliente para organizaciones públicas y privadas.',
                'description' => '<p>Forma técnicos medios para apoyar labores comerciales, administrativas y de servicio al cliente. Integra comunicación, gestión documental, mercadeo, ventas, logística, herramientas tecnológicas e inglés orientado al ámbito empresarial.</p>',
                'curriculum' => '<p>Servicio al cliente, comunicación, gestión documental, mercadeo y ventas, logística, herramientas administrativas e inglés.</p>',
            ],
            [
                'aliases' => ['Contabilidad y Finanzas'],
                'name' => 'Contabilidad y finanzas',
                'summary' => 'Formación para registrar, analizar e interpretar información contable y financiera.',
                'description' => '<p>Desarrolla competencias para registrar, analizar e interpretar información contable y financiera que apoye la toma de decisiones. Incluye tributación, activos, pasivos y patrimonio, administración financiera, costos, seguros, pensiones, herramientas digitales y gestión empresarial.</p>',
                'curriculum' => '<p>Contabilidad financiera, costos, finanzas, tributación, tecnologías digitales, gestión empresarial e inglés aplicado.</p>',
            ],
            [
                'aliases' => ['Logística y Distribución'],
                'name' => 'Administración logística y distribución',
                'summary' => 'Formación en compras, comercio exterior, inventarios, operaciones y cadena de suministro.',
                'description' => '<p>Prepara técnicos para participar en compras, importaciones y exportaciones, administración de inventarios, operaciones, manufactura y cadena de suministro. El programa incorpora procesos aduaneros, medios de pago, transporte, almacenamiento, calidad y herramientas tecnológicas.</p>',
                'curriculum' => '<p>Compras, importación y exportación, logística, inventarios, operaciones, manufactura, aduanas e inglés para la comunicación.</p>',
            ],
            [
                'aliases' => ['Dibujo Técnico'],
                'name' => 'Dibujo y modelado de edificaciones',
                'summary' => 'Representación, diseño y modelado de edificaciones con dibujo técnico y herramientas digitales.',
                'description' => '<p>Desarrolla competencias para representar, diseñar y modelar edificaciones mediante dibujo técnico, herramientas digitales y modelos tridimensionales. Aborda planos, BIM, renderizado, maquetas, procesos constructivos, instalaciones, normativa y fundamentos del diseño arquitectónico y urbanístico.</p>',
                'curriculum' => '<p>Modelado asistido por computadora, BIM, renderizado, técnicas de presentación, maquetas, dibujo y diseño arquitectónico y procesos constructivos.</p>',
            ],
            [
                'aliases' => ['Redes de Computadoras'],
                'name' => 'Configuración y soporte a redes de comunicación y sistemas operativos',
                'summary' => 'Instalación, configuración y soporte de redes, computadoras y sistemas operativos.',
                'description' => '<p>Forma técnicos para instalar, configurar, administrar y mantener redes de comunicación, computadoras y sistemas operativos. Integra cableado, servidores, ciberseguridad, programación, bases de datos, robótica, Internet de las Cosas y soporte a tecnologías de información.</p>',
                'curriculum' => '<p>Redes, sistemas operativos, soporte de computadoras, cableado, servidores, ciberseguridad, programación, bases de datos e Internet de las Cosas.</p>',
            ],
            [
                'aliases' => ['Electrotecnia'],
                'name' => 'Electrotecnia',
                'summary' => 'Fundamentos y aplicaciones de electricidad, electrónica, máquinas y sistemas de control.',
                'description' => '<p>Desarrolla fundamentos y aplicaciones de electricidad y electrónica para construir, analizar y mantener circuitos, instalaciones, máquinas y sistemas de control. Incluye mediciones, motores, transformadores, electrónica analógica y digital, automatización, controladores programables, neumática, hidráulica y seguridad eléctrica.</p>',
                'curriculum' => '<p>Electricidad, electrónica, instalaciones, máquinas eléctricas, control industrial, PLC, neumática e hidráulica, mantenimiento y seguridad ocupacional.</p>',
            ],
            [
                'aliases' => [],
                'name' => 'Instalación y mantenimiento de sistemas eléctricos industriales',
                'summary' => 'Instalación, puesta en servicio y mantenimiento de sistemas eléctricos industriales.',
                'description' => '<p>Prepara técnicos para instalar, poner en servicio y mantener sistemas eléctricos industriales. Comprende redes eléctricas, sistemas de control y automatización, electrónica de potencia, electroneumática, hidráulica, dispositivos programables y aplicaciones básicas de energías renovables.</p>',
                'curriculum' => '<p>Sistemas eléctricos industriales, mantenimiento, control y automatización, electrónica de potencia, electroneumática, hidráulica, sistemas programables y energías renovables.</p>',
            ],
        ];

        foreach ($specialties as $position => $specialty) {
            $aliases = array_values(array_unique([...$specialty['aliases'], $specialty['name']]));
            $existing = DB::table('specialties')->whereIn('name', $aliases)->first();
            $data = [
                'name' => $specialty['name'],
                'slug' => Str::slug($specialty['name']),
                'summary' => $specialty['summary'],
                'grade_levels' => '10.º, 11.º y 12.º',
                'description' => $specialty['description'],
                'curriculum' => $specialty['curriculum'],
                'status' => 'draft',
                'verified_at' => null,
                'published_at' => null,
                'sort_order' => ($position + 1) * 10,
                'updated_at' => $now,
            ];

            if ($existing && $this->isUntouchedDraft($existing)) {
                DB::table('specialties')->where('id', $existing->id)->update($data);
            } elseif (! DB::table('specialties')->where('name', $specialty['name'])->exists()) {
                DB::table('specialties')->insert([...$data, 'created_at' => $now]);
            }
        }

        $workshops = [
            ['7.º', 'Oficina secretarial y la inteligencia de las cosas (AIoT)', 'Explora la transformación de las oficinas mediante Internet de las Cosas e inteligencia artificial, incluyendo dispositivos inteligentes, automatización de tareas, gestión de datos y seguridad digital.'],
            ['7.º', 'Finanzas verdes', 'Introduce principios de administración, banca y finanzas relacionados con desarrollo sostenible, negocios verdes, economía circular y decisiones con criterios ambientales.'],
            ['7.º', 'Dibujo artístico', 'Desarrolla observación y expresión gráfica mediante principios de diseño, teoría del color y técnicas de dibujo artístico.'],
            ['7.º', 'Tecnologías de información y herramientas colaborativas', 'Desarrolla habilidades para crear, organizar y compartir información con sistemas operativos, herramientas de oficina, Internet y plataformas colaborativas.'],
            ['8.º', 'Gestión innovadora de la información', 'Acerca al estudiantado a la organización de oficinas, funciones ejecutivas secretariales, servicio de calidad y gestión de documentos físicos y electrónicos.'],
            ['8.º', 'Banca joven', 'Introduce administración empresarial, ahorro, crédito, matemática financiera, caja chica, conciliaciones bancarias, tesorería y controles operativos de caja.'],
            ['8.º', 'Dibujo técnico', 'Desarrolla representación gráfica normalizada mediante rotulado, dibujo geométrico, instrumentos y construcción de figuras en dos dimensiones.'],
            ['8.º', 'Mantenimiento preventivo y correctivo de dispositivos', 'Introduce diagnóstico, cuidado y reparación básica de dispositivos para prevenir fallas, optimizar su rendimiento y restablecer su funcionamiento.'],
            ['8.º', 'Explorando con automatización industrial', 'Explora corriente directa y alterna, control de máquinas, lógica cableada y programable, dispositivos electromecánicos y micro-PLC.'],
            ['9.º', 'Destrezas digitales para Secretariado y Ejecutivo', 'Desarrolla competencias para utilizar equipos de oficina, procesadores de texto, presentaciones, digitación e Internet de forma segura.'],
            ['9.º', 'Ideando emprendimientos juveniles', 'Introduce contabilidad, mercadeo y gestión empresarial para convertir ideas en propuestas de emprendimiento juvenil.'],
            ['9.º', 'Emprendimiento juvenil en acción', 'Guía la identificación de oportunidades y el diseño de iniciativas emprendedoras con creatividad, innovación, negociación y sostenibilidad.'],
            ['9.º', 'Diseño digital', 'Introduce la creación de productos gráficos mediante digitalización de imágenes, software especializado y proyectos visuales.'],
            ['9.º', 'Introducción a la logística industrial', 'Presenta procesos de logística e ingeniería industrial, estadística, mejora continua, gestión de calidad, Just in Time y ciclo PHVA.'],
            ['9.º', 'Programación de aplicaciones', 'Desarrolla pensamiento lógico y creatividad mediante algoritmos, diagramas de flujo y lenguajes de programación.'],
            ['9.º', 'Construye y programa tus propios dispositivos electrónicos IoT', 'Introduce electrónica modular, programación y comunicación de dispositivos conectados mediante placas, sensores y prototipos de Internet de las Cosas.'],
            ['7.º, 8.º y 9.º', 'Inglés conversacional', 'Desarrolla comprensión, producción, interacción y mediación en inglés mediante situaciones comunicativas, proyectos y tareas vinculadas con la vida cotidiana y la educación técnica.'],
        ];

        foreach ($workshops as $position => [$grade, $name, $description]) {
            $slug = Str::slug($name);
            $existing = DB::table('exploratory_workshops')->where('slug', $slug)->first();
            $data = [
                'name' => $name,
                'slug' => $slug,
                'grade_level' => $grade,
                'summary' => $description,
                'description' => '<p>'.$description.'</p>',
                'status' => 'draft',
                'verified_at' => null,
                'published_at' => null,
                'sort_order' => ($position + 1) * 10,
                'updated_at' => $now,
            ];

            if ($existing && $this->isUntouchedDraft($existing)) {
                DB::table('exploratory_workshops')->where('id', $existing->id)->update($data);
            } elseif (! $existing) {
                DB::table('exploratory_workshops')->insert([...$data, 'created_at' => $now]);
            }
        }
    }

    public function down(): void
    {
        // El catálogo es contenido editorial. No se elimina automáticamente para evitar pérdida de cambios posteriores.
    }

    private function isUntouchedDraft(object $record): bool
    {
        return $record->status === 'draft'
            && blank($record->summary)
            && blank($record->description)
            && blank($record->verified_at)
            && blank($record->published_at);
    }
};
