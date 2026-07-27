<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_are_available(): void
    {
        foreach (['/', '/noticias', '/informacion', '/especialidades', '/junta-administrativa', '/contacto', '/50-aniversario'] as $uri) {
            $this->get($uri)->assertOk()->assertSee('CTP Roberto Gamboa Valverde');
        }
    }

    public function test_home_uses_the_structured_portal_without_legacy_sections(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('modern-home__hero')
            ->assertSee('¿Qué necesita consultar?')
            ->assertSee('Talleres exploratorios')
            ->assertSee('Especialidades técnicas')
            ->assertSee('Próximas actividades')
            ->assertDontSee('values-section')
            ->assertDontSee('video-section')
            ->assertDontSee('feature-card');
    }

    public function test_public_footer_is_compact_and_contains_useful_navigation(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('site-footer__main')
            ->assertSee('Oferta educativa')
            ->assertSee('Talleres exploratorios')
            ->assertSee('Síganos')
            ->assertDontSee('footer-content');
    }

    public function test_admin_redirects_guests_to_login(): void
    {
        $this->get('/administracion')->assertRedirect('/administracion/ingresar');
        $this->get('/administracion/ingresar')
            ->assertOk()
            ->assertSee('class="login-remember"', false)
            ->assertSee('Mantener sesión iniciada')
            ->assertSee('Volver al sitio')
            ->assertSee('admin.css?v=', false);
    }

    public function test_public_navigation_is_semantic_and_marks_current_page(): void
    {
        $this->get('/calendario')
            ->assertOk()
            ->assertSee('aria-label="Navegación principal"', false)
            ->assertSee('class="nav-link active"', false)
            ->assertSee('aria-current="page"', false)
            ->assertSee('fa-calendar-days', false)
            ->assertDontSee('<a href="/calendario"><button', false);
    }

    public function test_institution_keeps_the_existing_url_with_a_clear_public_name(): void
    {
        $this->get('/informacion')
            ->assertOk()
            ->assertSee('Nuestra institución')
            ->assertSee('INSTITUCIÓN')
            ->assertSee('fa-school')
            ->assertSee('institution-hero')
            ->assertSee('Misión')
            ->assertSee('Visión')
            ->assertSee('Valores institucionales')
            ->assertDontSee('Información Académica')
            ->assertDontSee('specialty-header')
            ->assertDontSee('location-section');
    }

    public function test_public_navigation_shows_contextual_session_action(): void
    {
        $this->get('/')
            ->assertSee('Iniciar sesión')
            ->assertDontSee('social-links')
            ->assertDontSee('Panel administrativo');

        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        $this->actingAs($admin)->get('/')
            ->assertSee('Administración')
            ->assertDontSee('Iniciar sesión');
    }
}
