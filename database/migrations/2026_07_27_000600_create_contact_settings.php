<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $permissionId = DB::table('permissions')->insertGetId([
            'name' => 'contact.manage',
            'display_name' => 'Gestionar información de contacto',
            'group' => 'Contacto',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roleIds = DB::table('roles')->whereIn('name', ['super-admin', 'editor'])->pluck('id');
        foreach ($roleIds as $roleId) {
            DB::table('permission_role')->insertOrIgnore([
                'permission_id' => $permissionId,
                'role_id' => $roleId,
            ]);
        }

        $settings = [
            ['contact_heading', 'Comuníquese con nosotros', 'Título', 'text'],
            ['contact_intro', 'Consulte los canales oficiales disponibles para recibir atención institucional.', 'Texto introductorio', 'textarea'],
            ['contact_phone', '2250-8555', 'Teléfono principal', 'text'],
            ['contact_phone_secondary', '2250-8547', 'Teléfono secundario', 'text'],
            ['contact_email', 'ctp.robertogamboa@mep.go.cr', 'Correo electrónico', 'email'],
            ['contact_hours', null, 'Horario de atención', 'text'],
            ['contact_address', null, 'Dirección', 'textarea'],
            ['contact_map_url', null, 'Enlace del mapa', 'url'],
            ['contact_verified_at', null, 'Fecha de verificación', 'date'],
            ['contact_source', null, 'Fuente o responsable', 'text'],
        ];

        foreach ($settings as [$key, $value, $label, $type]) {
            if (DB::table('site_settings')->where('key', $key)->exists()) {
                $updates = [
                    'group' => 'contacto',
                    'label' => $label,
                    'type' => $type,
                    'updated_at' => now(),
                ];
                $currentValue = DB::table('site_settings')->where('key', $key)->value('value');
                if (($key === 'contact_phone' && $currentValue === '2215-1100') || ($key === 'contact_email' && blank($currentValue))) {
                    $updates['value'] = $value;
                }
                DB::table('site_settings')->where('key', $key)->update($updates);
            } else {
                DB::table('site_settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'group' => 'contacto',
                    'label' => $label,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        $permissionId = DB::table('permissions')->where('name', 'contact.manage')->value('id');
        if ($permissionId) {
            DB::table('permission_role')->where('permission_id', $permissionId)->delete();
            DB::table('permissions')->where('id', $permissionId)->delete();
        }

        DB::table('site_settings')->whereIn('key', [
            'contact_heading',
            'contact_intro',
            'contact_phone_secondary',
            'contact_hours',
            'contact_address',
            'contact_map_url',
            'contact_verified_at',
            'contact_source',
        ])->delete();
    }
};
