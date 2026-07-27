<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('description')->nullable();
            $table->string('route_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $sections = [
            ['news', 'Noticias', 'Publicaciones y actualidad institucional', 'news'],
            ['institution', 'Institución', 'Misión, visión y valores', 'information'],
            ['specialties', 'Especialidades', 'Oferta técnica de 10.º a 12.º', 'specialties'],
            ['workshops', 'Talleres exploratorios', 'Oferta exploratoria de 7.º a 9.º', 'workshops'],
            ['board', 'Junta Administrativa', 'Publicaciones, productos y transparencia', 'board'],
            ['contact', 'Contacto', 'Canales, mapa y formulario de consultas', 'contact'],
            ['services', 'Servicios', 'Catálogo de servicios institucionales', 'services.index'],
            ['calendar', 'Calendario', 'Actividades y fechas institucionales', 'calendar.index'],
            ['practice', 'Práctica profesional', 'Vinculación, pasantías y práctica', 'experiences.index'],
            ['directory', 'Directorio', 'Contactos por departamento', 'directory'],
            ['documents', 'Documentos', 'Biblioteca documental pública', 'documents'],
            ['anniversary', '50 Aniversario', 'Contenido conmemorativo', 'anniversary'],
        ];

        foreach ($sections as $index => [$key, $label, $description, $route]) {
            DB::table('site_sections')->insert([
                'key' => $key,
                'label' => $label,
                'description' => $description,
                'route_name' => $route,
                'is_active' => true,
                'sort_order' => ($index + 1) * 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $permissionId = DB::table('permissions')->insertGetId([
            'name' => 'site-sections.manage',
            'display_name' => 'Gestionar estado público del sitio',
            'group' => 'Configuración',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $roleId) {
            DB::table('permission_role')->insertOrIgnore(['permission_id' => $permissionId, 'role_id' => $roleId]);
        }
    }

    public function down(): void
    {
        $permissionId = DB::table('permissions')->where('name', 'site-sections.manage')->value('id');
        if ($permissionId) {
            DB::table('permission_role')->where('permission_id', $permissionId)->delete();
            DB::table('permissions')->where('id', $permissionId)->delete();
        }
        Schema::dropIfExists('site_sections');
    }
};
