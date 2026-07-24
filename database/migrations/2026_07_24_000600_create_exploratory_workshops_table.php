<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('specialties', function (Blueprint $table): void {
            $table->string('grade_levels')->default('10.º, 11.º y 12.º')->after('summary');
        });

        Schema::create('exploratory_workshops', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('grade_level');
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->string('responsible')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        foreach ([['workshops.view', 'Ver talleres exploratorios', 'Talleres'], ['workshops.manage', 'Gestionar talleres exploratorios', 'Talleres'], ['workshops.publish', 'Publicar talleres exploratorios', 'Talleres']] as [$name, $displayName, $group]) {
            DB::table('permissions')->updateOrInsert(['name' => $name], ['display_name' => $displayName, 'group' => $group, 'created_at' => now(), 'updated_at' => now()]);
        }
        $permissionIds = DB::table('permissions')->whereIn('name', ['workshops.view', 'workshops.manage', 'workshops.publish'])->pluck('id');
        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $roleId) {
            foreach ($permissionIds as $permissionId) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $roleId, 'permission_id' => $permissionId]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('exploratory_workshops');
        Schema::table('specialties', fn (Blueprint $table) => $table->dropColumn('grade_levels'));
        DB::table('permissions')->whereIn('name', ['workshops.view', 'workshops.manage', 'workshops.publish'])->delete();
    }
};
