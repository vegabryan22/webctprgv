<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_contact_page_uses_structured_settings_and_functional_form(): void
    {
        $response = $this->get('/contacto')
            ->assertOk()
            ->assertSee('contact-primary')
            ->assertSee('contact-socials')
            ->assertSee('contact-hero')
            ->assertSee('2250-8555')
            ->assertSee('ctp.robertogamboa@mep.go.cr')
            ->assertSee('Ver directorio')
            ->assertSee('Envíe su consulta')
            ->assertSee(route('contact.submit'))
            ->assertSee('privacy_consent');

        foreach (config('site.social') as $social) {
            $response->assertSee($social['url'])->assertSee($social['label']);
        }

        $this->assertLessThan(
            strpos($response->getContent(), 'contact-channels'),
            strpos($response->getContent(), 'formulario-contacto'),
        );
    }

    public function test_editor_can_manage_public_contact_information(): void
    {
        $editor = User::factory()->create();
        $editor->roles()->attach(Role::where('name', 'editor')->firstOrFail());

        $this->actingAs($editor)
            ->get(route('admin.contact.edit'))
            ->assertOk()
            ->assertSee('Contacto público');

        $this->actingAs($editor)
            ->put(route('admin.contact.update'), [
                'contact_heading' => 'Atención a la comunidad',
                'contact_intro' => 'Canales institucionales actualizados.',
                'contact_phone' => '2200-0000',
                'contact_phone_secondary' => '',
                'contact_email' => 'contacto@example.test',
                'contact_notification_email' => 'buzon@example.test',
                'contact_hours' => 'Lunes a viernes',
                'contact_address' => 'Dirección verificada',
                'contact_map_url' => 'https://maps.google.com/example',
                'contact_verified_at' => '2026-07-27',
                'contact_source' => 'Dirección',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('2200-0000', SiteSetting::where('key', 'contact_phone')->value('value'));
        $this->get('/contacto')
            ->assertSee('Atención a la comunidad')
            ->assertSee('contacto@example.test')
            ->assertSee('Dirección verificada')
            ->assertSee('contact-map')
            ->assertSee('https://www.google.com/maps?q=Direcci%C3%B3n+verificada&amp;output=embed', false)
            ->assertSee('Verificado el 27/07/2026')
            ->assertSee('Fuente: Dirección');
    }

    public function test_contact_administration_requires_its_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.contact.edit'))
            ->assertForbidden();
    }
}
