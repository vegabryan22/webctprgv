<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponsiveLayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_representative_public_pages_include_mobile_viewport_and_navigation(): void
    {
        foreach (['/', '/informacion', '/especialidades', '/talleres-exploratorios', '/junta-administrativa', '/contacto', '/calendario', '/biblioteca-documental'] as $uri) {
            $this->get($uri)
                ->assertOk()
                ->assertSee('name="viewport"', false)
                ->assertSee('nav-toggle');
        }
    }

    public function test_stylesheets_keep_phone_tablet_and_accessibility_guards(): void
    {
        $site = file_get_contents(public_path('css/site.css'));
        $admin = file_get_contents(public_path('css/admin.css'));
        $calendar = file_get_contents(public_path('css/calendar.css'));

        $this->assertStringContainsString('@media (max-width: 380px)', $site);
        $this->assertStringContainsString('(pointer: coarse)', $site);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $site);
        $this->assertStringContainsString('@media (max-width: 850px)', $admin);
        $this->assertStringContainsString('overflow-x: auto', $admin);
        $this->assertStringContainsString('@media (max-width: 560px)', $calendar);
    }
}
