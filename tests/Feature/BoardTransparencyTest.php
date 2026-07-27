<?php

namespace Tests\Feature;

use App\Models\BoardMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTransparencyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_board_page_starts_with_confirmed_products_without_invented_prices(): void
    {
        $this->get('/junta-administrativa')
            ->assertOk()
            ->assertSee('Integración pendiente de verificación')
            ->assertSee('Camisas del uniforme')
            ->assertSee('Cuaderno de comunicaciones')
            ->assertSee('Precio pendiente de confirmación')
            ->assertDontSee('₡8,500')
            ->assertDontSee('Licitación #CTPRGV-2025-003')
            ->assertDontSee('Renovación del laboratorio de cómputo');
    }

    public function test_expired_members_and_drafts_are_not_public(): void
    {
        BoardMember::create($this->memberAttributes(['name' => 'Integrante borrador']));
        BoardMember::create($this->memberAttributes([
            'name' => 'Integrante vencido', 'status' => 'published', 'verified_at' => now(),
            'published_at' => now(), 'term_ends_at' => today()->subDay(),
        ]));

        $this->get('/junta-administrativa')
            ->assertDontSee('Integrante borrador')
            ->assertDontSee('Integrante vencido');
    }

    public function test_administrator_can_publish_verified_member_and_report(): void
    {
        $admin = $this->superAdmin();
        $this->actingAs($admin)->post(route('admin.board-members.store'), [
            'name' => 'Persona autorizada',
            'position' => 'Presidencia',
            'term_starts_at' => today()->startOfYear()->toDateString(),
            'term_ends_at' => today()->addYear()->toDateString(),
            'source' => 'Acuerdo institucional 01-2026',
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 0,
        ])->assertRedirect(route('admin.board-members.index'));

        $this->actingAs($admin)->post(route('admin.board-records.store'), [
            'title' => 'Contratación institucional',
            'slug' => 'contratacion-institucional',
            'type' => 'procurement',
            'summary' => 'Proceso institucional verificado.',
            'responsible' => 'Junta Administrativa',
            'source' => 'Acta 02-2026',
            'record_date' => today()->toDateString(),
            'valid_until' => today()->addMonth()->toDateString(),
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 0,
        ])->assertRedirect(route('admin.board-records.index'));

        $this->get('/junta-administrativa')
            ->assertOk()
            ->assertSee('Persona autorizada')
            ->assertSee('Contratación institucional')
            ->assertSee('Licitaciones y contrataciones')
            ->assertSee('Acta 02-2026');
    }

    public function test_publication_requires_source_and_verification(): void
    {
        $this->actingAs($this->superAdmin())->post(route('admin.board-records.store'), [
            'title' => 'Proyecto sin respaldo',
            'slug' => 'proyecto-sin-respaldo',
            'type' => 'project',
            'responsible' => 'Junta',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertSessionHasErrors(['source', 'verified_at']);

        $this->assertDatabaseCount('board_transparency_records', 2);
    }

    public function test_board_maintenance_supports_categories_and_optional_prices(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)
            ->get(route('admin.board-records.create'))
            ->assertOk()
            ->assertSee('Licitación o contratación')
            ->assertSee('Uniforme')
            ->assertSee('Material')
            ->assertSee('Precio (opcional)');

        $this->actingAs($admin)->post(route('admin.board-records.store'), [
            'title' => 'Producto con precio confirmado',
            'slug' => 'producto-con-precio-confirmado',
            'type' => 'uniform',
            'summary' => 'Producto institucional verificado.',
            'price' => '9500.00',
            'price_note' => 'Precio vigente',
            'responsible' => 'Junta Administrativa',
            'source' => 'Lista oficial',
            'record_date' => today()->toDateString(),
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 30,
        ])->assertRedirect(route('admin.board-records.index'));

        $this->get('/junta-administrativa')
            ->assertSee('Producto con precio confirmado')
            ->assertSee('₡9.500,00');
    }

    private function memberAttributes(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Integrante', 'position' => 'Vocalía', 'source' => 'Acta',
            'status' => 'draft', 'sort_order' => 0,
        ], $overrides);
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
