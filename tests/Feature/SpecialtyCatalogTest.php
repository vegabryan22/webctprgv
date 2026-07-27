<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialtyCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_curricular_specialties_start_as_documented_reviewable_drafts(): void
    {
        $this->assertSame(7, Specialty::where('status', 'draft')->count());
        $this->assertDatabaseHas('specialties', [
            'name' => 'Configuración y soporte a redes de comunicación y sistemas operativos',
            'status' => 'draft',
        ]);
        $this->assertDatabaseHas('specialties', [
            'name' => 'Instalación y mantenimiento de sistemas eléctricos industriales',
            'status' => 'draft',
        ]);
        $this->assertDatabaseMissing('specialties', ['name' => 'Redes de Computadoras']);
        $this->get('/especialidades')->assertOk()->assertSee('Oferta técnica en proceso de verificación')->assertDontSee('alto índice de inserción laboral');
    }

    public function test_only_published_specialties_are_public(): void
    {
        $specialty = Specialty::firstOrFail();
        $specialty->update([
            'summary' => 'Formación técnica confirmada.',
            'description' => '<p>Contenido oficial.</p>',
            'status' => 'published',
            'verified_at' => now(),
            'published_at' => now(),
        ]);

        $this->get('/especialidades')->assertSee($specialty->name);
        $this->get(route('specialties.show', $specialty))->assertOk()->assertSee('Contenido oficial');
        $this->get(route('specialties.show', Specialty::where('status', 'draft')->firstOrFail()))->assertNotFound();
    }

    public function test_super_admin_can_complete_and_publish_specialty(): void
    {
        $specialty = Specialty::firstOrFail();
        $this->actingAs($this->superAdmin())->put(route('admin.specialties.update', $specialty), [
            'name' => $specialty->name,
            'slug' => $specialty->slug,
            'summary' => 'Resumen validado por Coordinación Técnica.',
            'grade_levels' => '10.º, 11.º y 12.º',
            'description' => '<p>Descripción validada.</p>',
            'official_program_url' => 'https://detce.mep.go.cr/programas-estudio',
            'status' => 'published',
            'verified_at' => now()->toDateString(),
            'sort_order' => 10,
        ])->assertRedirect(route('admin.specialties.index'));

        $this->assertDatabaseHas('specialties', ['id' => $specialty->id, 'status' => 'published']);
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
