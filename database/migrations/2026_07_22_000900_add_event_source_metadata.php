<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->string('source', 30)->default('ctprgv')->after('status')->index();
            $table->string('source_reference')->nullable()->after('source');
            $table->boolean('is_tentative')->default(false)->after('source_reference')->index();
            $table->unsignedTinyInteger('source_priority')->default(100)->after('is_tentative');
        });

        DB::table('events')->where('slug', 'like', 'mep-etp-2026-%')->update([
            'source' => 'mep',
            'source_reference' => 'Calendario 2026 del MEP',
            'is_tentative' => true,
            'source_priority' => 20,
        ]);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->dropIndex(['source']);
            $table->dropIndex(['is_tentative']);
            $table->dropColumn(['source', 'source_reference', 'is_tentative', 'source_priority']);
        });
    }
};
