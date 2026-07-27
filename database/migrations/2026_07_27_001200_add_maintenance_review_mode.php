<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        foreach ([
            ['maintenance_enabled', '0', 'Modo mantenimiento', 'boolean'],
            ['maintenance_title', 'Estamos preparando el sitio', 'Título de mantenimiento', 'text'],
            ['maintenance_message', 'Estamos revisando y actualizando el contenido institucional. Regrese pronto.', 'Mensaje de mantenimiento', 'textarea'],
        ] as [$key, $value, $label, $type]) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'mantenimiento',
                    'label' => $label,
                    'type' => $type,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        DB::table('roles')->updateOrInsert(
            ['name' => 'lector-sitio'],
            [
                'display_name' => 'Lector del sitio',
                'description' => 'Puede iniciar sesión y revisar el sitio público durante el modo mantenimiento, sin acceso al panel.',
                'is_system' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        $roleId = DB::table('roles')->where('name', 'lector-sitio')->value('id');
        if ($roleId && ! DB::table('role_user')->where('role_id', $roleId)->exists()) {
            DB::table('permission_role')->where('role_id', $roleId)->delete();
            DB::table('roles')->where('id', $roleId)->delete();
        }

        DB::table('site_settings')->whereIn('key', [
            'maintenance_enabled',
            'maintenance_title',
            'maintenance_message',
        ])->delete();
    }
};
