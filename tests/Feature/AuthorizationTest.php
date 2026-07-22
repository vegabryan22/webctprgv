<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_admin_permission_cannot_access_panel(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/administracion')->assertForbidden();
    }

    public function test_permissions_limit_administration_modules(): void
    {
        $access = Permission::create(['name' => 'admin.access', 'display_name' => 'Acceder', 'group' => 'Administración']);
        $pages = Permission::create(['name' => 'pages.view', 'display_name' => 'Ver páginas', 'group' => 'Contenido']);
        $role = Role::create(['name' => 'lector', 'display_name' => 'Lector']);
        $role->permissions()->sync([$access->id, $pages->id]);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user)->get('/administracion')->assertOk();
        $this->actingAs($user)->get('/administracion/paginas')->assertOk();
        $this->actingAs($user)->get('/administracion/usuarios')->assertForbidden();
    }

    public function test_super_admin_bypasses_individual_permissions(): void
    {
        $role = Role::create(['name' => 'super-admin', 'display_name' => 'Superadministración']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user)->get('/administracion')->assertOk();
    }
}
