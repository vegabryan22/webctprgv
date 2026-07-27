<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curricular_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('specialty_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('exploratory_workshop_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('grade_level', 50);
            $table->string('language', 20)->default('es');
            $table->string('file_path', 500);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['specialty_id', 'sort_order']);
            $table->index(['exploratory_workshop_id', 'sort_order']);
        });

        $this->seedSpecialtyDocuments();
        $this->seedWorkshopDocuments();
    }

    public function down(): void
    {
        Schema::dropIfExists('curricular_documents');
    }

    private function seedSpecialtyDocuments(): void
    {
        $documents = [
            'Ejecutivo comercial y de servicio al cliente' => [
                ['10.º', 'es', 'ejecutivo-comercial-servicio-cliente-10.pdf'],
                ['11.º', 'es', 'ejecutivo-comercial-servicio-cliente-11.pdf'],
                ['12.º', 'es', 'ejecutivo-comercial-servicio-cliente-12.pdf'],
            ],
            'Contabilidad y finanzas' => [
                ['10.º', 'es', 'contabilidad-finanzas-10.pdf'],
                ['11.º', 'es', 'contabilidad-finanzas-11.pdf'],
                ['12.º', 'es', 'contabilidad-finanzas-12.pdf'],
            ],
            'Administración logística y distribución' => [
                ['10.º', 'es', 'administracion-logistica-distribucion-10-es.pdf'],
                ['10.º', 'en', 'administracion-logistica-distribucion-10-en.pdf'],
                ['11.º', 'es', 'administracion-logistica-distribucion-11-es.pdf'],
                ['11.º', 'en', 'administracion-logistica-distribucion-11-en.pdf'],
                ['12.º', 'es', 'administracion-logistica-distribucion-12-es.pdf'],
            ],
            'Dibujo y modelado de edificaciones' => [
                ['10.º', 'es', 'dibujo-modelado-edificaciones-10.pdf'],
                ['11.º', 'es', 'dibujo-modelado-edificaciones-11.pdf'],
                ['12.º', 'es', 'dibujo-modelado-edificaciones-12.pdf'],
            ],
            'Configuración y soporte a redes de comunicación y sistemas operativos' => [
                ['10.º', 'es', 'configuracion-soporte-redes-sistemas-operativos-10.pdf'],
                ['11.º', 'es', 'configuracion-soporte-redes-sistemas-operativos-11.pdf'],
                ['12.º', 'es', 'configuracion-soporte-redes-sistemas-operativos-12.pdf'],
            ],
            'Electrotecnia' => [
                ['10.º', 'es', 'electrotecnia-10.pdf'],
                ['11.º', 'es', 'electrotecnia-11.pdf'],
                ['12.º', 'es', 'electrotecnia-12.pdf'],
            ],
            'Instalación y mantenimiento de sistemas eléctricos industriales' => [
                ['10.º', 'es', 'instalacion-mantenimiento-sistemas-electricos-industriales-10.pdf'],
                ['11.º', 'es', 'instalacion-mantenimiento-sistemas-electricos-industriales-11.pdf'],
                ['12.º', 'es', 'instalacion-mantenimiento-sistemas-electricos-industriales-12.pdf'],
            ],
        ];

        foreach ($documents as $specialtyName => $plans) {
            $specialtyId = DB::table('specialties')->where('name', $specialtyName)->value('id');
            if (! $specialtyId) {
                continue;
            }

            foreach ($plans as $position => [$grade, $language, $filename]) {
                DB::table('curricular_documents')->insert([
                    'specialty_id' => $specialtyId,
                    'title' => 'Programa de estudio de '.$grade,
                    'grade_level' => $grade,
                    'language' => $language,
                    'file_path' => 'documentos/planes-estudio/especialidades/'.$filename,
                    'sort_order' => ($position + 1) * 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedWorkshopDocuments(): void
    {
        $documents = [
            'Oficina secretarial y la inteligencia de las cosas (AIoT)' => ['7.º', 'oficina-secretarial-inteligencia-cosas-aiot-7.pdf'],
            'Finanzas verdes' => ['7.º', 'finanzas-verdes-7.pdf'],
            'Dibujo artístico' => ['7.º', 'dibujo-artistico-7.pdf'],
            'Tecnologías de información y herramientas colaborativas' => ['7.º', 'tecnologias-informacion-herramientas-colaborativas-7.pdf'],
            'Gestión innovadora de la información' => ['8.º', 'gestion-innovadora-informacion-8.pdf'],
            'Banca joven' => ['8.º', 'banca-joven-8.pdf'],
            'Dibujo técnico' => ['8.º', 'dibujo-tecnico-8.pdf'],
            'Mantenimiento preventivo y correctivo de dispositivos' => ['8.º', 'mantenimiento-preventivo-correctivo-dispositivos-8.pdf'],
            'Explorando con automatización industrial' => ['8.º', 'explorando-automatizacion-industrial-8.pdf'],
            'Destrezas digitales para Secretariado y Ejecutivo' => ['9.º', 'destrezas-digitales-secretariado-ejecutivo-9.pdf'],
            'Ideando emprendimientos juveniles' => ['9.º', 'ideando-emprendimientos-juveniles-9.pdf'],
            'Emprendimiento juvenil en acción' => ['9.º', 'emprendimiento-juvenil-accion-9.pdf'],
            'Diseño digital' => ['9.º', 'diseno-digital-9.pdf'],
            'Introducción a la logística industrial' => ['9.º', 'introduccion-logistica-industrial-9.pdf'],
            'Programación de aplicaciones' => ['9.º', 'programacion-aplicaciones-9.pdf'],
            'Construye y programa tus propios dispositivos electrónicos IoT' => ['9.º', 'construye-programa-dispositivos-electronicos-iot-9.pdf'],
        ];

        foreach ($documents as $workshopName => [$grade, $filename]) {
            $workshopId = DB::table('exploratory_workshops')->where('name', $workshopName)->value('id');
            if (! $workshopId) {
                continue;
            }

            DB::table('curricular_documents')->insert([
                'exploratory_workshop_id' => $workshopId,
                'title' => 'Programa del taller de '.$grade,
                'grade_level' => $grade,
                'language' => 'es',
                'file_path' => 'documentos/planes-estudio/talleres/'.$filename,
                'sort_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $englishWorkshopId = DB::table('exploratory_workshops')->where('name', 'Inglés conversacional')->value('id');
        if ($englishWorkshopId) {
            foreach (['7.º', '8.º', '9.º'] as $position => $grade) {
                DB::table('curricular_documents')->insert([
                    'exploratory_workshop_id' => $englishWorkshopId,
                    'title' => 'Programa de Inglés conversacional de '.$grade,
                    'grade_level' => $grade,
                    'language' => 'en',
                    'file_path' => 'documentos/planes-estudio/talleres/ingles-conversacional-7-8-9.pdf',
                    'sort_order' => ($position + 1) * 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
