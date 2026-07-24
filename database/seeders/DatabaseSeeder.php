<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\NavigationItem;
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
            ['news.view', 'Ver noticias', 'Noticias'],
            ['news.manage', 'Gestionar noticias y categorías', 'Noticias'],
            ['news.publish', 'Publicar noticias', 'Noticias'],
            ['services.view', 'Ver servicios', 'Servicios'],
            ['services.manage', 'Gestionar servicios y categorías', 'Servicios'],
            ['services.publish', 'Publicar servicios', 'Servicios'],
            ['specialties.view', 'Ver especialidades', 'Especialidades'],
            ['specialties.manage', 'Gestionar especialidades', 'Especialidades'],
            ['specialties.publish', 'Publicar especialidades', 'Especialidades'],
            ['workshops.view', 'Ver talleres exploratorios', 'Talleres'],
            ['workshops.manage', 'Gestionar talleres exploratorios', 'Talleres'],
            ['workshops.publish', 'Publicar talleres exploratorios', 'Talleres'],
            ['directory.view', 'Ver directorio', 'Directorio'],
            ['directory.manage', 'Gestionar directorio', 'Directorio'],
            ['directory.publish', 'Publicar contactos', 'Directorio'],
            ['documents.view', 'Ver documentos', 'Documentos'],
            ['documents.manage', 'Gestionar documentos y categorías', 'Documentos'],
            ['documents.publish', 'Publicar documentos', 'Documentos'],
            ['experiences.view', 'Ver vinculación y práctica', 'Vinculación'],
            ['experiences.manage', 'Gestionar vinculación y práctica', 'Vinculación'],
            ['experiences.publish', 'Publicar vinculación y práctica', 'Vinculación'],
            ['board.view', 'Ver Junta y transparencia', 'Junta Administrativa'],
            ['board.manage', 'Gestionar Junta y transparencia', 'Junta Administrativa'],
            ['board.publish', 'Publicar Junta y transparencia', 'Junta Administrativa'],
            ['menu.view', 'Ver menú principal', 'Contenido'],
            ['menu.manage', 'Gestionar menú principal', 'Contenido'],
            ['events.view', 'Ver actividades', 'Calendario'],
            ['events.manage', 'Gestionar actividades y categorías', 'Calendario'],
            ['events.publish', 'Publicar y cancelar actividades', 'Calendario'],
            ['settings.manage', 'Gestionar configuración', 'Configuración'],
            ['gitops.view', 'Ver estado GitOps', 'GitOps'],
            ['gitops.deploy', 'Solicitar despliegues', 'GitOps'],
            ['gitops.rollback', 'Revertir despliegues', 'GitOps'],
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
        $editor->permissions()->sync($permissions->only(['admin.access', 'pages.view', 'pages.manage', 'pages.publish', 'news.view', 'news.manage', 'news.publish', 'services.view', 'services.manage', 'services.publish', 'specialties.view', 'specialties.manage', 'specialties.publish', 'workshops.view', 'workshops.manage', 'workshops.publish', 'directory.view', 'directory.manage', 'directory.publish', 'documents.view', 'documents.manage', 'documents.publish', 'experiences.view', 'experiences.manage', 'experiences.publish', 'board.view', 'board.manage', 'board.publish'])->pluck('id'));

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

        collect([
            ['Académica', 'academica', '#002f5d'],
            ['Técnica', 'tecnica', '#4cb11d'],
            ['Cultural', 'cultural', '#8b5cf6'],
            ['Deportiva', 'deportiva', '#e67e22'],
            ['Administrativa', 'administrativa', '#64748b'],
            ['Institucional', 'institucional', '#c59f00'],
        ])->each(fn (array $category) => EventCategory::firstOrCreate(
            ['slug' => $category[1]],
            ['name' => $category[0], 'color' => $category[2]],
        ));

        NavigationItem::firstOrCreate(
            ['route_name' => 'calendar.index'],
            ['label' => 'CALENDARIO', 'sort_order' => 70, 'is_active' => true],
        );

        NavigationItem::firstOrCreate(
            ['route_name' => 'services.index'],
            ['label' => 'SERVICIOS', 'sort_order' => 65, 'is_active' => true],
        );

        NavigationItem::firstOrCreate(
            ['route_name' => 'experiences.index'],
            ['label' => 'PRÁCTICA', 'sort_order' => 64, 'is_active' => true],
        );

        if (($email = env('ADMIN_EMAIL')) && ($password = env('ADMIN_PASSWORD'))) {
            $admin = User::updateOrCreate(
                ['email' => $email],
                ['name' => env('ADMIN_NAME', 'Administrador'), 'password' => $password],
            );
            $admin->roles()->syncWithoutDetaching([$superAdmin->id]);
        }
    }
}
