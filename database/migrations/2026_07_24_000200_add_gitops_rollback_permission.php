<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Permission::firstOrCreate(
            ['name' => 'gitops.rollback'],
            ['display_name' => 'Revertir despliegues', 'group' => 'GitOps'],
        );
    }

    public function down(): void
    {
        Permission::where('name', 'gitops.rollback')->delete();
    }
};
