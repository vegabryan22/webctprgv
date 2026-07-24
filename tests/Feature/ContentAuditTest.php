<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\Role;
use App\Models\User;
use App\Services\ContentAuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_audit_detects_empty_links_prices_and_incomplete_forms(): void
    {
        ContentPage::where('route_name', 'contact')->update([
            'content' => '<a href="#">Información</a><p>Precio ₡8,500</p><form><input name="email"></form>',
        ]);

        $contact = app(ContentAuditService::class)->audit()->first(fn (array $result) => $result['page']->route_name === 'contact');

        $this->assertSame(3, $contact['findings']->count());
        $this->assertSame(25, $contact['score']);
        $this->assertEqualsCanonicalizing(
            ['Enlace sin destino', 'Precios publicados', 'Formulario sin destino'],
            $contact['findings']->pluck('title')->all(),
        );
    }

    public function test_authorized_user_can_open_editorial_review(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.content-audit.index'))
            ->assertOk()
            ->assertSee('Revisión editorial')
            ->assertSee('Páginas revisadas');
    }

    public function test_editorial_review_requires_page_view_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.content-audit.index'))
            ->assertForbidden();
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
