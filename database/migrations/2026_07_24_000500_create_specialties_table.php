<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('student_profile')->nullable();
            $table->longText('curriculum')->nullable();
            $table->longText('career_opportunities')->nullable();
            $table->string('official_program_url')->nullable();
            $table->string('coordinator')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        foreach ([['specialties.view', 'Ver especialidades', 'Especialidades'], ['specialties.manage', 'Gestionar especialidades', 'Especialidades'], ['specialties.publish', 'Publicar especialidades', 'Especialidades']] as [$name, $displayName, $group]) {
            DB::table('permissions')->updateOrInsert(['name' => $name], ['display_name' => $displayName, 'group' => $group, 'created_at' => now(), 'updated_at' => now()]);
        }
        $permissionIds = DB::table('permissions')->whereIn('name', ['specialties.view', 'specialties.manage', 'specialties.publish'])->pluck('id');
        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $roleId) {
            foreach ($permissionIds as $permissionId) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $roleId, 'permission_id' => $permissionId]);
            }
        }

        foreach (['Redes de Computadoras', 'Contabilidad y Finanzas', 'Logística y Distribución', 'Electrotecnia', 'Ejecutivo para Centros de Servicio', 'Dibujo Técnico'] as $position => $name) {
            DB::table('specialties')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => 'draft',
                'sort_order' => ($position + 1) * 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('specialties');
        DB::table('permissions')->whereIn('name', ['specialties.view', 'specialties.manage', 'specialties.publish'])->delete();
    }
};
