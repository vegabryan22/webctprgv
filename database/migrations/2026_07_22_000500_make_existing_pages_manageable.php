<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_pages', function (Blueprint $table): void {
            $table->string('route_name')->nullable()->unique()->after('slug');
            $table->boolean('is_system')->default(false)->after('route_name');
            $table->longText('script')->nullable()->after('content');
        });

        Schema::create('navigation_items', function (Blueprint $table): void {
            $table->id();
            $table->string('label');
            $table->string('route_name')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->boolean('open_in_new_tab')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');

        Schema::table('content_pages', function (Blueprint $table): void {
            $table->dropUnique(['route_name']);
            $table->dropColumn(['route_name', 'is_system', 'script']);
        });
    }
};
