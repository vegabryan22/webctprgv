<?php

namespace Tests\Feature;

use App\Models\CurricularDocument;
use App\Models\Role;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpecialtyCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_documented_curricular_specialties_are_published(): void
    {
        $this->assertSame(7, Specialty::where('status', 'published')->count());
        $this->assertSame(23, CurricularDocument::whereNotNull('specialty_id')->count());
        $this->assertDatabaseHas('specialties', [
            'name' => 'Configuración y soporte a redes de comunicación y sistemas operativos',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('specialties', [
            'name' => 'Instalación y mantenimiento de sistemas eléctricos industriales',
            'status' => 'published',
        ]);
        $this->assertDatabaseMissing('specialties', ['name' => 'Redes de Computadoras']);
        $this->get('/especialidades')
            ->assertOk()
            ->assertSee('catalog-grid')
            ->assertSee('Configuración y soporte a redes de comunicación y sistemas operativos')
            ->assertSee('Instalación y mantenimiento de sistemas eléctricos industriales')
            ->assertDontSee('alto índice de inserción laboral');

        $networks = Specialty::where('name', 'Configuración y soporte a redes de comunicación y sistemas operativos')->firstOrFail();
        $this->get(route('specialties.show', $networks))
            ->assertOk()
            ->assertSee('curricular-detail__hero')
            ->assertSee('curricular-detail__plans')
            ->assertSee('Perfil del estudiante')
            ->assertSee('Administración de servidores y fundamentos de ciberseguridad.')
            ->assertDontSee('Información oficial')
            ->assertSee('Planes de estudio por nivel')
            ->assertSee('configuracion-soporte-redes-sistemas-operativos-10.pdf')
            ->assertSee('configuracion-soporte-redes-sistemas-operativos-11.pdf')
            ->assertSee('configuracion-soporte-redes-sistemas-operativos-12.pdf');
    }

    public function test_all_documented_specialties_have_profile_and_expanded_training_content(): void
    {
        Specialty::where('status', 'published')->each(function (Specialty $specialty): void {
            $this->assertNotEmpty($specialty->student_profile, $specialty->name);
            $this->assertStringContainsString('<ul>', $specialty->curriculum, $specialty->name);
            $this->assertNull($specialty->career_opportunities, $specialty->name);
        });
    }

    public function test_every_curricular_document_points_to_a_public_file(): void
    {
        CurricularDocument::each(
            fn (CurricularDocument $document) => $this->assertFileExists(public_path($document->file_path)),
        );
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
        $draft = Specialty::create([
            'name' => 'Especialidad pendiente',
            'slug' => 'especialidad-pendiente',
            'summary' => 'Contenido sin publicar.',
            'grade_levels' => '10.º, 11.º y 12.º',
            'status' => 'draft',
        ]);

        $this->get('/especialidades')->assertSee($specialty->name);
        $this->get(route('specialties.show', $specialty))->assertOk()->assertSee('Contenido oficial');
        $this->get(route('specialties.show', $draft))->assertNotFound();
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

    public function test_super_admin_can_create_a_specialty_with_a_plan(): void
    {
        Storage::disk('public')->makeDirectory('curricular-plans');
        $user = $this->superAdmin();

        $this->actingAs($user)->post(route('admin.specialties.store'), [
            'name' => 'Especialidad con plan',
            'slug' => 'especialidad-con-plan',
            'summary' => 'Resumen breve.',
            'grade_levels' => '10.º, 11.º y 12.º',
            'plan_files' => [UploadedFile::fake()->create('programa.pdf', 100, 'application/pdf')],
            'plan_grades' => ['10.º'],
            'plan_languages' => ['es'],
            'plan_titles' => ['Programa oficial de 10.º'],
            'status' => 'draft',
            'sort_order' => 90,
        ])->assertRedirect(route('admin.specialties.index'));

        $specialty = Specialty::where('slug', 'especialidad-con-plan')->firstOrFail();
        $this->assertDatabaseHas('curricular_documents', [
            'specialty_id' => $specialty->id,
            'title' => 'Programa oficial de 10.º',
            'grade_level' => '10.º',
        ]);

        Storage::disk('public')->delete(
            str($specialty->curricularDocuments()->firstOrFail()->file_path)->after('storage/')->toString(),
        );
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
