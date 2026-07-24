<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#003665');
            $table->timestamps();
        });

        Schema::create('news_articles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('news_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('content');
            $table->string('image_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });

        foreach ([
            ['news.view', 'Ver noticias', 'Noticias'],
            ['news.manage', 'Gestionar noticias y categorías', 'Noticias'],
            ['news.publish', 'Publicar noticias', 'Noticias'],
        ] as [$name, $displayName, $group]) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                ['display_name' => $displayName, 'group' => $group, 'updated_at' => now(), 'created_at' => now()],
            );
        }

        $permissionIds = DB::table('permissions')->whereIn('name', ['news.view', 'news.manage', 'news.publish'])->pluck('id');
        $roleIds = DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id');
        foreach ($roleIds as $roleId) {
            foreach ($permissionIds as $permissionId) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $roleId, 'permission_id' => $permissionId]);
            }
        }

        foreach ([['Comunicados', 'comunicados', '#003665'], ['Académica', 'academica', '#2f7d18'], ['Técnica', 'tecnica', '#c59f00'], ['Comunidad', 'comunidad', '#7c3aed']] as [$name, $slug, $color]) {
            DB::table('news_categories')->insert(compact('name', 'slug', 'color') + ['created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
        Schema::dropIfExists('news_categories');
        DB::table('permissions')->whereIn('name', ['news.view', 'news.manage', 'news.publish'])->delete();
    }
};
