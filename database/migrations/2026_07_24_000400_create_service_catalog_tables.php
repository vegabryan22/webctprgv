<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->default('fa-circle-info');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('institutional_services', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('service_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('audience')->default('general');
            $table->string('responsible')->nullable();
            $table->string('schedule')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('external_url')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        foreach ([['services.view', 'Ver servicios', 'Servicios'], ['services.manage', 'Gestionar servicios y categorías', 'Servicios'], ['services.publish', 'Publicar servicios', 'Servicios']] as [$name, $displayName, $group]) {
            DB::table('permissions')->updateOrInsert(['name' => $name], ['display_name' => $displayName, 'group' => $group, 'created_at' => now(), 'updated_at' => now()]);
        }
        $permissionIds = DB::table('permissions')->whereIn('name', ['services.view', 'services.manage', 'services.publish'])->pluck('id');
        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $roleId) {
            foreach ($permissionIds as $permissionId) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $roleId, 'permission_id' => $permissionId]);
            }
        }

        foreach ([['Gestiones estudiantiles', 'gestiones-estudiantiles', 'fa-file-signature', 10], ['Bienestar estudiantil', 'bienestar-estudiantil', 'fa-hand-holding-heart', 20], ['Apoyo académico', 'apoyo-academico', 'fa-graduation-cap', 30]] as [$name, $slug, $icon, $sortOrder]) {
            DB::table('service_categories')->insert(['name' => $name, 'slug' => $slug, 'icon' => $icon, 'sort_order' => $sortOrder, 'created_at' => now(), 'updated_at' => now()]);
        }

        DB::table('navigation_items')->updateOrInsert(
            ['route_name' => 'services.index'],
            ['label' => 'SERVICIOS', 'sort_order' => 65, 'is_active' => true, 'open_in_new_tab' => false, 'created_at' => now(), 'updated_at' => now()],
        );
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('route_name', 'services.index')->delete();
        Schema::dropIfExists('institutional_services');
        Schema::dropIfExists('service_categories');
        DB::table('permissions')->whereIn('name', ['services.view', 'services.manage', 'services.publish'])->delete();
    }
};
