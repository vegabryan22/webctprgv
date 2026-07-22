<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\LegacyPageImporter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect([
            ['admin.access', 'Acceder al panel', 'Administración'],
            ['users.view', 'Ver usuarios', 'Usuarios'],
            ['users.create', 'Crear usuarios', 'Usuarios'],
            ['users.update', 'Editar usuarios', 'Usuarios'],
            ['users.delete', 'Eliminar usuarios', 'Usuarios'],
            ['roles.view', 'Ver roles y permisos', 'Seguridad'],
            ['roles.manage', 'Gestionar roles y permisos', 'Seguridad'],
            ['pages.view', 'Ver páginas', 'Contenido'],
            ['pages.manage', 'Gestionar páginas', 'Contenido'],
            ['pages.publish', 'Publicar páginas', 'Contenido'],
            ['menu.view', 'Ver menú principal', 'Contenido'],
            ['menu.manage', 'Gestionar menú principal', 'Contenido'],
            ['settings.manage', 'Gestionar configuración', 'Configuración'],
            ['gitops.view', 'Ver estado GitOps', 'GitOps'],
            ['gitops.deploy', 'Solicitar despliegues', 'GitOps'],
        ])->mapWithKeys(function (array $item): array {
            $permission = Permission::updateOrCreate(
                ['name' => $item[0]],
                ['display_name' => $item[1], 'group' => $item[2]],
            );

            return [$permission->name => $permission];
        });

        $superAdmin = Role::updateOrCreate(
            ['name' => 'super-admin'],
            ['display_name' => 'Superadministración', 'description' => 'Acceso total e irrestricto.', 'is_system' => true],
        );
        $superAdmin->permissions()->sync($permissions->pluck('id'));

        $editor = Role::updateOrCreate(
            ['name' => 'editor'],
            ['display_name' => 'Editor de contenido', 'description' => 'Gestiona y publica el contenido del sitio.', 'is_system' => true],
        );
        $editor->permissions()->sync($permissions->only(['admin.access', 'pages.view', 'pages.manage', 'pages.publish'])->pluck('id'));

        $userManager = Role::updateOrCreate(
            ['name' => 'gestor-usuarios'],
            ['display_name' => 'Gestor de usuarios', 'description' => 'Administra cuentas sin modificar permisos.', 'is_system' => true],
        );
        $userManager->permissions()->sync($permissions->only(['admin.access', 'users.view', 'users.create', 'users.update', 'users.delete', 'roles.view'])->pluck('id'));

        collect([
            ['site_name', 'CTP Roberto Gamboa Valverde', 'general', 'Nombre del sitio', 'text'],
            ['contact_phone', '2215-1100', 'contacto', 'Teléfono', 'text'],
            ['contact_email', '', 'contacto', 'Correo electrónico', 'email'],
            ['office_hours', 'L-V 8:00 AM - 4:00 PM', 'contacto', 'Horario de atención', 'text'],
        ])->each(fn (array $item) => SiteSetting::updateOrCreate(
            ['key' => $item[0]],
            ['value' => $item[1], 'group' => $item[2], 'label' => $item[3], 'type' => $item[4]],
        ));

        app(LegacyPageImporter::class)->import();

        if (($email = env('ADMIN_EMAIL')) && ($password = env('ADMIN_PASSWORD'))) {
            $admin = User::updateOrCreate(
                ['email' => $email],
                ['name' => env('ADMIN_NAME', 'Administrador'), 'password' => $password],
            );
            $admin->roles()->syncWithoutDetaching([$superAdmin->id]);
        }
    }
}
