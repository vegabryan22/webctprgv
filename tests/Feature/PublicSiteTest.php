<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    public function test_public_pages_are_available(): void
    {
        foreach (['/', '/noticias', '/informacion', '/especialidades', '/junta-administrativa', '/contacto', '/50-aniversario'] as $uri) {
            $this->get($uri)->assertOk()->assertSee('CTP Roberto Gamboa Valverde');
        }
    }

    public function test_admin_redirects_guests_to_login(): void
    {
        $this->get('/administracion')->assertRedirect('/administracion/ingresar');
    }
}
