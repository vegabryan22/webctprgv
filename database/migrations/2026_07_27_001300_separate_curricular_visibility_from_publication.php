<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('specialties', function (Blueprint $table): void {
            $table->boolean('is_active')->default(true)->after('status')->index();
        });

        Schema::table('exploratory_workshops', function (Blueprint $table): void {
            $table->boolean('is_active')->default(true)->after('status')->index();
        });
    }

    public function down(): void
    {
        Schema::table('specialties', function (Blueprint $table): void {
            $table->dropColumn('is_active');
        });

        Schema::table('exploratory_workshops', function (Blueprint $table): void {
            $table->dropColumn('is_active');
        });
    }
};
