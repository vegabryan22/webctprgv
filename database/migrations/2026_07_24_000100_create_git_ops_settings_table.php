<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('git_ops_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('repository')->nullable();
            $table->string('branch')->default('main');
            $table->string('workflow')->default('deploy.yml');
            $table->text('token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('git_ops_settings');
    }
};
