<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->default('fa-folder-open');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        Schema::create('institutional_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('document_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('replaced_by_id')->nullable()->constrained('institutional_documents')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('version')->nullable();
            $table->string('responsible')->nullable();
            $table->string('audience')->default('general');
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable()->index();
            $table->string('status')->default('draft')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        foreach ([['documents.view', 'Ver documentos', 'Documentos'], ['documents.manage', 'Gestionar documentos y categorías', 'Documentos'], ['documents.publish', 'Publicar documentos', 'Documentos']] as [$name,$display_name,$group]) {
            DB::table('permissions')->updateOrInsert(['name' => $name], compact('display_name', 'group') + ['created_at' => now(), 'updated_at' => now()]);
        }
        $permissions = DB::table('permissions')->whereIn('name', ['documents.view', 'documents.manage', 'documents.publish'])->pluck('id');
        foreach (DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id') as $role) {
            foreach ($permissions as $permission) {
                DB::table('permission_role')->updateOrInsert(['role_id' => $role, 'permission_id' => $permission]);
            }
        }
        foreach ([['Reglamentos', 'reglamentos', 'fa-scale-balanced', 10], ['Circulares', 'circulares', 'fa-envelope-open-text', 20], ['Formularios', 'formularios', 'fa-file-signature', 30], ['Guías y protocolos', 'guias-protocolos', 'fa-book-open', 40]] as [$name,$slug,$icon,$sort]) {
            DB::table('document_categories')->insert(['name' => $name, 'slug' => $slug, 'icon' => $icon, 'sort_order' => $sort, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_documents');
        Schema::dropIfExists('document_categories');
        DB::table('permissions')->whereIn('name', ['documents.view', 'documents.manage', 'documents.publish'])->delete();
    }
};
