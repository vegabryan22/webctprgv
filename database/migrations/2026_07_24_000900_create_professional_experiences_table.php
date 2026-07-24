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
        Schema::create('professional_experiences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['professional_practice', 'internship', 'technical_visit']);
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('process_stages')->nullable();
            $table->string('responsible');
            $table->string('contact_email')->nullable();
            $table->string('company_contact_email')->nullable();
            $table->string('duration')->nullable();
            $table->string('schedule')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('professional_experience_specialty', function (Blueprint $table): void {
            $table->unsignedBigInteger('professional_experience_id');
            $table->unsignedBigInteger('specialty_id');
            $table->primary(['professional_experience_id', 'specialty_id'], 'experience_specialty_pk');
            $table->foreign('professional_experience_id', 'experience_specialty_experience_fk')->references('id')->on('professional_experiences')->cascadeOnDelete();
            $table->foreign('specialty_id', 'experience_specialty_specialty_fk')->references('id')->on('specialties')->cascadeOnDelete();
        });

        Schema::create('institutional_document_professional_experience', function (Blueprint $table): void {
            $table->unsignedBigInteger('professional_experience_id');
            $table->unsignedBigInteger('institutional_document_id');
            $table->primary(['professional_experience_id', 'institutional_document_id'], 'document_experience_pk');
            $table->foreign('professional_experience_id', 'document_experience_experience_fk')->references('id')->on('professional_experiences')->cascadeOnDelete();
            $table->foreign('institutional_document_id', 'document_experience_document_fk')->references('id')->on('institutional_documents')->cascadeOnDelete();
        });

        collect([
            ['experiences.view', 'Ver vinculación y práctica'],
            ['experiences.manage', 'Gestionar vinculación y práctica'],
            ['experiences.publish', 'Publicar vinculación y práctica'],
        ])->each(function (array $item): void {
            Permission::updateOrCreate(
                ['name' => $item[0]],
                ['display_name' => $item[1], 'group' => 'Vinculación'],
            );
        });

        $permissionIds = Permission::whereIn('name', ['experiences.view', 'experiences.manage', 'experiences.publish'])->pluck('id');
        Role::whereIn('name', ['super-admin', 'editor'])->get()->each(
            fn (Role $role) => $role->permissions()->syncWithoutDetaching($permissionIds),
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_document_professional_experience');
        Schema::dropIfExists('professional_experience_specialty');
        Schema::dropIfExists('professional_experiences');
        Permission::whereIn('name', ['experiences.view', 'experiences.manage', 'experiences.publish'])->delete();
    }
};
