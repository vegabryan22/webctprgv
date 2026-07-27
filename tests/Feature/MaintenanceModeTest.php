<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SiteSection;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_maintenance_mode_blocks_guests_but_keeps_login_available(): void
    {
        $this->enableMaintenance();

        $this->get('/')
            ->assertStatus(503)
            ->assertHeader('Retry-After', '3600')
            ->assertSee('Estamos preparando el sitio')
            ->assertSee('Iniciar sesión como revisor');
        $this->get('/admision-y-matricula')->assertStatus(503)->assertDontSee('Prematrícula para 7.º');
        $this->get(route('login'))->assertOk();
    }

    public function test_authenticated_reader_can_review_site_without_admin_access(): void
    {
        $this->enableMaintenance();
        $reader = User::factory()->create();
        $reader->roles()->attach(Role::where('name', 'lector-sitio')->firstOrFail());

        $this->actingAs($reader)
            ->get('/')
            ->assertOk()
            ->assertSee('Vista de revisión')
            ->assertSee('Cerrar sesión');
        $this->actingAs($reader)->get('/admision-y-matricula')->assertOk()->assertSee('Prematrícula para 7.º');
        $this->actingAs($reader)->get('/administracion')->assertForbidden();
    }

    public function test_reader_login_stays_authenticated_and_returns_to_requested_page(): void
    {
        $this->enableMaintenance();
        $reader = User::factory()->create(['password' => 'clave-segura']);
        $reader->roles()->attach(Role::where('name', 'lector-sitio')->firstOrFail());

        $this->get(route('login', ['redirect' => '/admision-y-matricula']))->assertOk();
        $this->post(route('login.store'), [
            'email' => $reader->email,
            'password' => 'clave-segura',
        ])->assertRedirect('/admision-y-matricula');

        $this->assertAuthenticatedAs($reader);
        $this->get('/admision-y-matricula')->assertOk();
    }

    public function test_super_admin_can_activate_and_customize_maintenance(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());
        $active = SiteSection::pluck('key')->all();

        $this->actingAs($admin)->put(route('admin.site-sections.update'), [
            'active' => $active,
            'maintenance_enabled' => '1',
            'maintenance_title' => 'Contenido en evaluación',
            'maintenance_message' => 'Estamos revisando la información antes de publicarla.',
        ])->assertSessionHas('success');

        $this->assertSame('1', SiteSetting::where('key', 'maintenance_enabled')->value('value'));
        $this->assertSame('Contenido en evaluación', SiteSetting::where('key', 'maintenance_title')->value('value'));
        auth()->logout();
        $this->get('/')->assertStatus(503)->assertSee('Contenido en evaluación');
    }

    private function enableMaintenance(): void
    {
        SiteSetting::where('key', 'maintenance_enabled')->update(['value' => '1']);
    }
}
