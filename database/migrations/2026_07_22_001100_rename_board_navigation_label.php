<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('navigation_items')->where('route_name', 'board')->update([
            'label' => 'JUNTA ADMINISTRATIVA',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('route_name', 'board')->where('label', 'JUNTA ADMINISTRATIVA')->update([
            'label' => 'JUNTA',
            'updated_at' => now(),
        ]);
    }
};
