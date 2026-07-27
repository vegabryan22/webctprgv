<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->enrichSpecialties();
        $this->enrichWorkshops();
    }

    public function down(): void
    {
        // El contenido editorial no se revierte automáticamente para evitar pérdida de ediciones posteriores.
    }

    private function enrichSpecialties(): void
    {
        $specialties = [
            'ejecutivo-comercial-y-de-servicio-al-cliente' => [
                'baseline' => '<p>Servicio al cliente, comunicación, gestión documental, mercadeo y ventas, logística, herramientas administrativas e inglés.</p>',
                'student_profile' => '<p>Esta formación favorece a estudiantes con interés en la comunicación, el servicio a las personas, la organización de información y los procesos comerciales. El programa desarrolla iniciativa, trabajo colaborativo, comunicación oral y escrita, uso responsable de herramientas digitales y atención de calidad.</p>',
                'curriculum' => '<p>Los planes de 10.º, 11.º y 12.º articulan las siguientes áreas:</p><ul><li>Servicio y experiencia del cliente.</li><li>Comunicación empresarial y gestión documental.</li><li>Mercadeo, ventas y negociación.</li><li>Administración, logística y apoyo a operaciones comerciales.</li><li>Tecnologías digitales aplicadas a la oficina.</li><li>Emprendimiento e inglés orientado al ámbito empresarial.</li></ul>',
            ],
            'contabilidad-y-finanzas' => [
                'baseline' => '<p>Contabilidad financiera, costos, finanzas, tributación, tecnologías digitales, gestión empresarial e inglés aplicado.</p>',
                'student_profile' => '<p>Se orienta a estudiantes con interés en el análisis numérico, el orden documental y la interpretación de información económica. Fortalece la precisión, la confidencialidad, el pensamiento crítico, la resolución de problemas y el uso ético de datos contables y financieros.</p>',
                'curriculum' => '<p>Los planes de 10.º, 11.º y 12.º desarrollan progresivamente:</p><ul><li>Registro y análisis de operaciones contables.</li><li>Activos, pasivos, patrimonio y estados financieros.</li><li>Costos, presupuestos y administración financiera.</li><li>Tributación y normativa vinculada con la actividad empresarial.</li><li>Seguros, pensiones y productos financieros.</li><li>Herramientas digitales, gestión empresarial, emprendimiento e inglés aplicado.</li></ul>',
            ],
            'administracion-logistica-y-distribucion' => [
                'baseline' => '<p>Compras, importación y exportación, logística, inventarios, operaciones, manufactura, aduanas e inglés para la comunicación.</p>',
                'student_profile' => '<p>Está dirigida a estudiantes interesados en planificar, organizar y mejorar el movimiento de bienes e información. Desarrolla pensamiento sistémico, capacidad de análisis, trabajo colaborativo, solución de problemas y atención rigurosa a la calidad y la seguridad de las operaciones.</p>',
                'curriculum' => '<p>Los programas disponibles de 10.º, 11.º y 12.º comprenden:</p><ul><li>Compras, abastecimiento y relación con proveedores.</li><li>Administración de inventarios, almacenamiento y distribución.</li><li>Importaciones, exportaciones, aduanas y medios de pago.</li><li>Transporte, operaciones y cadena de suministro.</li><li>Manufactura, calidad y mejora de procesos.</li><li>Tecnologías para la gestión logística e inglés para la comunicación.</li></ul>',
            ],
            'dibujo-y-modelado-de-edificaciones' => [
                'baseline' => '<p>Modelado asistido por computadora, BIM, renderizado, técnicas de presentación, maquetas, dibujo y diseño arquitectónico y procesos constructivos.</p>',
                'student_profile' => '<p>Favorece a estudiantes con interés en la representación visual, el diseño, la construcción y el trabajo preciso. Desarrolla percepción espacial, creatividad, comunicación gráfica, interpretación de normas, atención al detalle y manejo responsable de herramientas de dibujo y modelado.</p>',
                'curriculum' => '<p>La formación de 10.º, 11.º y 12.º integra:</p><ul><li>Dibujo técnico y representación arquitectónica.</li><li>Modelado asistido por computadora y metodología BIM.</li><li>Modelos tridimensionales, renderizado y presentación de proyectos.</li><li>Maquetas y técnicas de comunicación visual.</li><li>Procesos, materiales e instalaciones constructivas.</li><li>Diseño arquitectónico y urbanístico, normativa y documentación de planos.</li></ul>',
            ],
            'configuracion-y-soporte-a-redes-de-comunicacion-y-sistemas-operativos' => [
                'baseline' => '<p>Redes, sistemas operativos, soporte de computadoras, cableado, servidores, ciberseguridad, programación, bases de datos e Internet de las Cosas.</p>',
                'student_profile' => '<p>Se orienta a estudiantes con curiosidad por el funcionamiento de computadoras, redes y servicios digitales. Fortalece el razonamiento lógico, la investigación de fallas, el trabajo metódico, la seguridad de la información, la comunicación técnica y el aprendizaje continuo.</p>',
                'curriculum' => '<p>Los planes de 10.º, 11.º y 12.º incluyen:</p><ul><li>Arquitectura, mantenimiento y soporte de computadoras.</li><li>Sistemas operativos de escritorio y servidor.</li><li>Cableado, redes de comunicación y servicios de red.</li><li>Administración de servidores y fundamentos de ciberseguridad.</li><li>Programación, bases de datos y automatización.</li><li>Robótica, Internet de las Cosas y soporte a tecnologías de información.</li></ul>',
            ],
            'electrotecnia' => [
                'baseline' => '<p>Electricidad, electrónica, instalaciones, máquinas eléctricas, control industrial, PLC, neumática e hidráulica, mantenimiento y seguridad ocupacional.</p>',
                'student_profile' => '<p>Está dirigida a estudiantes interesados en comprender y construir sistemas eléctricos y electrónicos. Desarrolla razonamiento matemático, análisis de circuitos, precisión en mediciones, resolución de fallas, trabajo seguro y responsabilidad en el uso de equipos y energía.</p>',
                'curriculum' => '<p>La formación articulada de 10.º, 11.º y 12.º aborda:</p><ul><li>Fundamentos de electricidad, electrónica y mediciones.</li><li>Circuitos e instalaciones eléctricas.</li><li>Máquinas eléctricas, motores y transformadores.</li><li>Electrónica analógica y digital.</li><li>Control industrial, automatización y controladores programables.</li><li>Neumática, hidráulica, mantenimiento y seguridad ocupacional.</li></ul>',
            ],
            'instalacion-y-mantenimiento-de-sistemas-electricos-industriales' => [
                'baseline' => '<p>Sistemas eléctricos industriales, mantenimiento, control y automatización, electrónica de potencia, electroneumática, hidráulica, sistemas programables y energías renovables.</p>',
                'student_profile' => '<p>Favorece a estudiantes con interés en instalaciones, mantenimiento y automatización industrial. Desarrolla pensamiento técnico, interpretación de planos, diagnóstico de fallas, precisión, trabajo colaborativo y aplicación permanente de normas de seguridad.</p>',
                'curriculum' => '<p>Los planes de 10.º, 11.º y 12.º desarrollan:</p><ul><li>Instalación y puesta en servicio de sistemas eléctricos industriales.</li><li>Medición, diagnóstico y mantenimiento eléctrico.</li><li>Redes, máquinas y dispositivos eléctricos.</li><li>Sistemas de control y automatización.</li><li>Electrónica de potencia y dispositivos programables.</li><li>Electroneumática, hidráulica y aplicaciones básicas de energías renovables.</li></ul>',
            ],
        ];

        foreach ($specialties as $slug => $content) {
            $specialty = DB::table('specialties')->where('slug', $slug)->first();

            if (! $specialty) {
                continue;
            }

            $updates = [];
            if (blank($specialty->student_profile)) {
                $updates['student_profile'] = $content['student_profile'];
            }
            if ($specialty->curriculum === $content['baseline']) {
                $updates['curriculum'] = $content['curriculum'];
            }
            if ($updates !== []) {
                DB::table('specialties')->where('id', $specialty->id)->update([
                    ...$updates,
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function enrichWorkshops(): void
    {
        $workshops = [
            'oficina-secretarial-y-la-inteligencia-de-las-cosas-aiot' => '<p>Este taller explora cómo el Internet de las Cosas y la inteligencia artificial transforman las labores de oficina. El estudiantado reconoce dispositivos inteligentes, automatiza tareas sencillas y analiza el uso de datos y asistentes digitales en procesos administrativos.</p><h3>Contenidos principales</h3><ul><li>Oficinas inteligentes e Internet de las Cosas.</li><li>Dispositivos conectados y automatización de tareas.</li><li>Gestión, protección y uso responsable de datos.</li><li>Inteligencia artificial y herramientas de asistencia para labores administrativas.</li><li>Seguridad digital aplicada al entorno de oficina.</li></ul>',
            'finanzas-verdes' => '<p>Introduce principios de administración, banca y finanzas desde una perspectiva de desarrollo sostenible. Las actividades relacionan las decisiones económicas con sus efectos ambientales y sociales.</p><h3>Contenidos principales</h3><ul><li>Empresa, administración y actividad económica.</li><li>Impuestos, negocios y productos financieros.</li><li>Ahorro, inversión y decisiones financieras responsables.</li><li>Bonos y finanzas verdes.</li><li>Economía circular y criterios ambientales.</li></ul>',
            'dibujo-artistico' => '<p>Desarrolla la observación, la creatividad y la expresión gráfica mediante ejercicios de dibujo artístico. El estudiantado experimenta con materiales, composición y recursos visuales para comunicar ideas.</p><h3>Contenidos principales</h3><ul><li>Principios y elementos del diseño.</li><li>Teoría y aplicación del color.</li><li>Técnicas de dibujo y representación.</li><li>Uso adecuado de materiales e instrumentos.</li><li>Composición, observación y comunicación visual.</li></ul>',
            'tecnologias-de-informacion-y-herramientas-colaborativas' => '<p>Desarrolla habilidades para crear, organizar, procesar y compartir información mediante herramientas digitales. Promueve el trabajo colaborativo y el uso seguro y responsable de la tecnología.</p><h3>Contenidos principales</h3><ul><li>Sistemas operativos y organización de archivos.</li><li>Procesadores de texto, hojas electrónicas y presentaciones.</li><li>Internet, búsqueda y gestión de información.</li><li>Herramientas colaborativas y comunicación digital.</li><li>Ciudadanía, seguridad y responsabilidad digital.</li></ul>',
            'gestion-innovadora-de-la-informacion' => '<p>Acerca al estudiantado a la organización de oficinas y a las funciones ejecutivas y secretariales. Las actividades se centran en el servicio, la comunicación y la administración ordenada de documentos.</p><h3>Contenidos principales</h3><ul><li>Organización y áreas funcionales de la empresa.</li><li>Servicio de calidad y atención de llamadas y visitas.</li><li>Administración del tiempo y organización del trabajo.</li><li>Elaboración y presentación de documentos.</li><li>Gestión de archivos físicos y electrónicos.</li></ul>',
            'banca-joven' => '<p>Introduce conceptos de administración empresarial y operaciones financieras básicas cercanas a la vida de las personas jóvenes. Fortalece la toma de decisiones informadas sobre el dinero.</p><h3>Contenidos principales</h3><ul><li>Ahorro, crédito y productos bancarios.</li><li>Matemática financiera básica.</li><li>Caja chica y controles de efectivo.</li><li>Conciliaciones bancarias y tesorería.</li><li>Operaciones y controles de caja.</li></ul>',
            'dibujo-tecnico' => '<p>Desarrolla la capacidad de representar objetos y formas mediante normas de comunicación gráfica. Favorece la precisión, la interpretación espacial y el uso correcto de instrumentos.</p><h3>Contenidos principales</h3><ul><li>Rotulado y normalización del dibujo.</li><li>Uso y cuidado de instrumentos.</li><li>Trazados y construcciones geométricas.</li><li>Figuras y representaciones en dos dimensiones.</li><li>Precisión y comunicación técnica.</li></ul>',
            'mantenimiento-preventivo-y-correctivo-de-dispositivos' => '<p>Introduce procedimientos para cuidar, diagnosticar y recuperar el funcionamiento de dispositivos tecnológicos. El trabajo se realiza de manera ordenada, segura y orientada a prevenir fallas.</p><h3>Contenidos principales</h3><ul><li>Componentes y funcionamiento básico de dispositivos.</li><li>Mantenimiento preventivo y limpieza técnica.</li><li>Identificación y diagnóstico inicial de fallas.</li><li>Mantenimiento correctivo básico.</li><li>Seguridad, orden y documentación del trabajo realizado.</li></ul>',
            'explorando-con-automatizacion-industrial' => '<p>Explora fundamentos eléctricos y de control utilizados en procesos de automatización. El estudiantado realiza cálculos y montajes básicos bajo normas de seguridad.</p><h3>Contenidos principales</h3><ul><li>Principios de corriente directa y alterna.</li><li>Mediciones y montajes eléctricos básicos.</li><li>Dispositivos electromecánicos y control de máquinas.</li><li>Lógica cableada y lógica programable.</li><li>Introducción al micro-PLC y seguridad eléctrica.</li></ul>',
            'destrezas-digitales-para-secretariado-y-ejecutivo' => '<p>Desarrolla destrezas digitales para producir documentos y contenidos propios de labores secretariales y ejecutivas. Se enfatizan la exactitud, la ergonomía y el uso seguro de servicios digitales.</p><h3>Contenidos principales</h3><ul><li>Equipos y recursos tecnológicos de oficina.</li><li>Digitación con velocidad y exactitud.</li><li>Procesamiento y cotejo de documentos.</li><li>Creación de presentaciones y contenidos.</li><li>Internet, ergonomía y seguridad digital.</li></ul>',
            'ideando-emprendimientos-juveniles' => '<p>Integra contabilidad, mercadeo y gestión empresarial para transformar ideas en propuestas de emprendimiento juvenil. El estudiantado analiza recursos, información financiera y condiciones del entorno.</p><h3>Contenidos principales</h3><ul><li>Tipos de empresa y organización.</li><li>Talento humano, planillas y salud ocupacional.</li><li>Contabilidad y estados financieros básicos.</li><li>Mercadeo y análisis estadístico.</li><li>Industria 4.0, teletrabajo y formulación de ideas de negocio.</li></ul>',
            'emprendimiento-juvenil-en-accion' => '<p>Guía la identificación de oportunidades y el diseño de iniciativas emprendedoras. Emplea creatividad, innovación y análisis del entorno para convertir una idea en un modelo de negocio.</p><h3>Contenidos principales</h3><ul><li>Oportunidades, creatividad e innovación.</li><li>Generación y evaluación de ideas.</li><li>Diseño de modelos de negocio.</li><li>Negociación y toma de decisiones.</li><li>Sostenibilidad y economía circular.</li></ul>',
            'diseno-digital' => '<p>Introduce la creación y comunicación de productos gráficos mediante herramientas digitales. El estudiantado combina criterios visuales, digitalización y edición para desarrollar proyectos.</p><h3>Contenidos principales</h3><ul><li>Digitalización y tratamiento de imágenes.</li><li>Principios de composición y comunicación gráfica.</li><li>Herramientas de software especializado.</li><li>Edición y preparación de productos visuales.</li><li>Desarrollo de proyectos de diseño digital.</li></ul>',
            'introduccion-a-la-logistica-industrial' => '<p>Presenta procesos básicos de logística e ingeniería industrial para analizar y mejorar actividades productivas. Integra herramientas matemáticas, tecnológicas y de gestión de calidad.</p><h3>Contenidos principales</h3><ul><li>Fundamentos de logística e ingeniería industrial.</li><li>Matemática, estadística y herramientas tecnológicas.</li><li>Procesos, productividad y mejora continua.</li><li>Gestión de calidad y metodología Just in Time.</li><li>Ciclo PHVA para el análisis y mejora de procesos.</li></ul>',
            'programacion-de-aplicaciones' => '<p>Desarrolla pensamiento lógico y creatividad mediante la construcción progresiva de soluciones programadas. El estudiantado analiza problemas, representa procesos y crea aplicaciones básicas.</p><h3>Contenidos principales</h3><ul><li>Análisis y descomposición de problemas.</li><li>Algoritmos y diagramas de flujo.</li><li>Estructuras y fundamentos de programación.</li><li>Construcción y prueba de soluciones.</li><li>Aplicaciones en software, web y automatización.</li></ul>',
            'construye-y-programa-tus-propios-dispositivos-electronicos-iot' => '<p>Integra electrónica modular, programación y comunicación de dispositivos conectados. El estudiantado construye prototipos para proponer soluciones relacionadas con Internet de las Cosas.</p><h3>Contenidos principales</h3><ul><li>Fundamentos de electrónica y componentes modulares.</li><li>Placas de desarrollo, entradas y salidas.</li><li>Sensores, actuadores y comunicación.</li><li>Programación de dispositivos conectados.</li><li>Diseño y prueba de prototipos IoT.</li></ul>',
            'ingles-conversacional' => '<p>Desarrolla comprensión, producción, interacción y mediación en inglés mediante situaciones comunicativas, proyectos y tareas relacionadas con la vida cotidiana y la educación técnica. El programa articula el aprendizaje de 7.º, 8.º y 9.º y orienta el progreso hacia el nivel B1.1 del Marco Común Europeo al finalizar el tercer ciclo.</p><h3>Capacidades comunicativas</h3><ul><li>Comprender mensajes orales y escritos.</li><li>Participar en conversaciones y situaciones de interacción.</li><li>Producir mensajes orales y escritos con propósitos concretos.</li><li>Mediar información y colaborar en proyectos.</li><li>Aplicar inglés para fines específicos vinculados con la educación técnica.</li></ul>',
        ];

        foreach ($workshops as $slug => $description) {
            $workshop = DB::table('exploratory_workshops')->where('slug', $slug)->first();

            if ($workshop && $workshop->description === '<p>'.$workshop->summary.'</p>') {
                DB::table('exploratory_workshops')->where('id', $workshop->id)->update([
                    'description' => $description,
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
