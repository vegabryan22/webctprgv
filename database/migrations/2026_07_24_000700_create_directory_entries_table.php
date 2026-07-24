<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('department');
            $table->string('position')->nullable();
            $table->string('person_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('extension')->nullable();
            $table->string('email')->nullable();
            $table->string('schedule')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        foreach ([['directory.view', 'Ver directorio', 'Directorio'], ['directory.manage', 'Gestionar directorio', 'Directorio'], ['directory.publish', 'Publicar contactos', 'Directorio']] as [$name,$display_name,$group]) {
            DB::table('permissions')->updateOrInsert(['name' => $name], compact('display_name', 'group') + ['created_at' => now(), 'updated_at' => now()]);
        }
        $permissions = DB::table('permissions')->whereIn('name', ['directory.view', 'directory.manage', 'directory.publish'])->pluck('id');
        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $role) {
            foreach ($permissions as $permission) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $role, 'permission_id' => $permission]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_entries');
        DB::table('permissions')->whereIn('name', ['directory.view', 'directory.manage', 'directory.publish'])->delete();
    }
};
