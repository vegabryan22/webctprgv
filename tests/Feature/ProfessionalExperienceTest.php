<?php

namespace Tests\Feature;

use App\Models\ProfessionalExperience;
use App\Models\Role;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessionalExperienceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_section_starts_without_unverified_information(): void
    {
        $this->get('/practica-profesional')
            ->assertOk()
            ->assertSee('Información en proceso de verificación');
    }

    public function test_draft_and_unverified_modalities_are_not_public(): void
    {
        ProfessionalExperience::create($this->attributes(['title' => 'Modalidad borrador', 'slug' => 'borrador']));
        ProfessionalExperience::create($this->attributes([
            'title' => 'Sin verificar',
            'slug' => 'sin-verificar',
            'status' => 'published',
            'published_at' => now(),
        ]));

        $this->get('/practica-profesional')
            ->assertDontSee('Modalidad borrador')
            ->assertDontSee('Sin verificar');
    }

    public function test_administrator_can_publish_a_verified_modality_with_specialties(): void
    {
        $specialty = Specialty::create([
            'name' => 'Redes', 'slug' => 'redes', 'grade_levels' => '10.º a 12.º',
            'status' => 'published', 'verified_at' => now(), 'published_at' => now(),
        ]);

        $this->actingAs($this->superAdmin())->post(route('admin.experiences.store'), [
            'title' => 'Práctica profesional',
            'slug' => 'practica-profesional',
            'type' => 'professional_practice',
            'summary' => 'Proceso formativo en el sector productivo.',
            'responsible' => 'Coordinación con la Empresa',
            'contact_email' => 'practica@example.test',
            'company_contact_email' => 'empresas@example.test',
            'specialty_ids' => [$specialty->id],
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 0,
        ])->assertRedirect(route('admin.experiences.index'));

        $experience = ProfessionalExperience::firstOrFail();
        $this->assertTrue($experience->specialties->contains($specialty));
        $this->get(route('experiences.show', $experience))
            ->assertOk()
            ->assertSee('Práctica profesional')
            ->assertSee('Redes')
            ->assertSee('empresas@example.test');
    }

    public function test_publishing_requires_verification_date(): void
    {
        $this->actingAs($this->superAdmin())->post(route('admin.experiences.store'), [
            'title' => 'Visita técnica',
            'slug' => 'visita-tecnica',
            'type' => 'technical_visit',
            'responsible' => 'Coordinación Técnica',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertSessionHasErrors('verified_at');

        $this->assertDatabaseCount('professional_experiences', 0);
    }

    private function attributes(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Modalidad',
            'slug' => 'modalidad',
            'type' => 'internship',
            'responsible' => 'Coordinación',
            'status' => 'draft',
            'sort_order' => 0,
        ], $overrides);
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
