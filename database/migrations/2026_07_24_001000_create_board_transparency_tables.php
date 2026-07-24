<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('board_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('position');
            $table->date('term_starts_at')->nullable();
            $table->date('term_ends_at')->nullable();
            $table->string('source')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('board_transparency_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['project', 'process', 'report']);
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('responsible');
            $table->string('source');
            $table->date('record_date')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('board_record_document', function (Blueprint $table): void {
            $table->unsignedBigInteger('board_transparency_record_id');
            $table->unsignedBigInteger('institutional_document_id');
            $table->primary(['board_transparency_record_id', 'institutional_document_id'], 'board_record_document_pk');
            $table->foreign('board_transparency_record_id', 'board_record_document_record_fk')->references('id')->on('board_transparency_records')->cascadeOnDelete();
            $table->foreign('institutional_document_id', 'board_record_document_document_fk')->references('id')->on('institutional_documents')->cascadeOnDelete();
        });

        collect([
            ['board.view', 'Ver Junta y transparencia'],
            ['board.manage', 'Gestionar Junta y transparencia'],
            ['board.publish', 'Publicar Junta y transparencia'],
        ])->each(fn (array $item) => Permission::updateOrCreate(
            ['name' => $item[0]],
            ['display_name' => $item[1], 'group' => 'Junta Administrativa'],
        ));

        $permissions = Permission::whereIn('name', ['board.view', 'board.manage', 'board.publish'])->pluck('id');
        Role::whereIn('name', ['super-admin', 'editor'])->get()->each(
            fn (Role $role) => $role->permissions()->syncWithoutDetaching($permissions),
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('board_record_document');
        Schema::dropIfExists('board_transparency_records');
        Schema::dropIfExists('board_members');
        Permission::whereIn('name', ['board.view', 'board.manage', 'board.publish'])->delete();
    }
};
