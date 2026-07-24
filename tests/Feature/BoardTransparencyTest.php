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

    public function test_board_page_starts_without_unverified_people_or_records(): void
    {
        $this->get('/junta-administrativa')
            ->assertOk()
            ->assertSee('Integración pendiente de verificación')
            ->assertSee('Sin publicaciones verificadas');
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
            'title' => 'Informe anual',
            'slug' => 'informe-anual',
            'type' => 'report',
            'summary' => 'Resumen institucional verificado.',
            'responsible' => 'Junta Administrativa',
            'source' => 'Acta 02-2026',
            'record_date' => today()->toDateString(),
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 0,
        ])->assertRedirect(route('admin.board-records.index'));

        $this->get('/junta-administrativa')
            ->assertOk()
            ->assertSee('Persona autorizada')
            ->assertSee('Informe anual')
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

        $this->assertDatabaseCount('board_transparency_records', 0);
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
