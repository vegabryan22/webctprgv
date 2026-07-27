<?php

namespace Tests\Feature;

use App\Models\CurricularDocument;
use App\Models\ExploratoryWorkshop;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExploratoryWorkshopTest extends TestCase
{
    use RefreshDatabase;

    public function test_workshops_and_specialties_are_presented_as_different_grade_paths(): void
    {
        $this->seed();
        $this->assertSame(17, ExploratoryWorkshop::where('status', 'published')->count());
        $this->assertSame(19, CurricularDocument::whereNotNull('exploratory_workshop_id')->count());
        $this->assertDatabaseHas('exploratory_workshops', [
            'name' => 'Oficina secretarial y la inteligencia de las cosas (AIoT)',
            'grade_level' => '7.º',
        ]);
        $this->assertDatabaseHas('exploratory_workshops', [
            'name' => 'Inglés conversacional',
            'grade_level' => '7.º, 8.º y 9.º',
        ]);
        $this->get('/talleres-exploratorios')
            ->assertOk()
            ->assertSee('7.º nivel')
            ->assertSee('8.º nivel')
            ->assertSee('9.º nivel')
            ->assertSee('Todo el tercer ciclo')
            ->assertDontSee('Talleres de 7.º')
            ->assertSee('Inglés conversacional')
            ->assertSee('catalog-grid');

        $english = ExploratoryWorkshop::where('name', 'Inglés conversacional')->firstOrFail();
        $this->get(route('workshops.show', $english))
            ->assertOk()
            ->assertSee('Capacidades comunicativas')
            ->assertSee('nivel B1.1')
            ->assertSee('Programa de Inglés conversacional de 7.º')
            ->assertSee('Programa de Inglés conversacional de 8.º')
            ->assertSee('Programa de Inglés conversacional de 9.º')
            ->assertSee('ingles-conversacional-7-8-9.pdf');
        $this->get('/especialidades')->assertOk()->assertSee('10.º, 11.º y 12.º')->assertSee('¿Busca talleres de 7.º, 8.º y 9.º?');
    }

    public function test_all_documented_workshops_have_expanded_pdf_based_content(): void
    {
        $this->seed();

        ExploratoryWorkshop::where('status', 'published')->each(function (ExploratoryWorkshop $workshop): void {
            $this->assertStringContainsString('<ul>', $workshop->description, $workshop->name);
            $this->assertStringContainsString('<li>', $workshop->description, $workshop->name);
        });
    }

    public function test_only_published_workshops_are_visible(): void
    {
        $this->seed();
        ExploratoryWorkshop::create(['name' => 'Taller confirmado', 'slug' => 'taller-confirmado', 'grade_level' => '7.º', 'summary' => 'Exploración técnica.', 'status' => 'published', 'published_at' => now()]);
        ExploratoryWorkshop::create(['name' => 'Taller borrador', 'slug' => 'taller-borrador', 'grade_level' => '8.º', 'summary' => 'Pendiente.', 'status' => 'draft']);
        $this->get('/talleres-exploratorios')->assertSee('Taller confirmado')->assertDontSee('Taller borrador');
        $this->get(route('workshops.show', ExploratoryWorkshop::where('slug', 'taller-borrador')->firstOrFail()))->assertNotFound();
    }

    public function test_super_admin_can_assign_a_workshop_to_all_third_cycle_levels(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        $workshop = ExploratoryWorkshop::where('name', 'Inglés conversacional')->firstOrFail();

        $this->actingAs($user)->put(route('admin.workshops.update', $workshop), [
            'name' => $workshop->name,
            'slug' => $workshop->slug,
            'grade_level' => '7.º, 8.º y 9.º',
            'summary' => $workshop->summary,
            'description' => $workshop->description,
            'status' => 'draft',
            'sort_order' => $workshop->sort_order,
        ])->assertRedirect(route('admin.workshops.index'));

        $this->assertDatabaseHas('exploratory_workshops', [
            'id' => $workshop->id,
            'grade_level' => '7.º, 8.º y 9.º',
        ]);
    }

    public function test_super_admin_can_create_a_workshop_with_image_and_plan(): void
    {
        Storage::disk('public')->makeDirectory('workshops');
        Storage::disk('public')->makeDirectory('curricular-plans');
        $this->seed();
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        $this->actingAs($user)->post(route('admin.workshops.store'), [
            'name' => 'Taller con recursos',
            'slug' => 'taller-con-recursos',
            'grade_level' => '8.º',
            'summary' => 'Resumen breve.',
            'description' => '<p>Descripción completa.</p>',
            'image' => UploadedFile::fake()->image('taller.jpg', 800, 500),
            'plan_files' => [UploadedFile::fake()->create('plan.pdf', 100, 'application/pdf')],
            'plan_grades' => ['8.º'],
            'plan_languages' => ['es'],
            'plan_titles' => ['Plan oficial de 8.º'],
            'status' => 'draft',
            'sort_order' => 90,
        ])->assertRedirect(route('admin.workshops.index'));

        $workshop = ExploratoryWorkshop::where('slug', 'taller-con-recursos')->firstOrFail();
        $this->assertNotNull($workshop->image_path);
        $this->assertDatabaseHas('curricular_documents', [
            'exploratory_workshop_id' => $workshop->id,
            'title' => 'Plan oficial de 8.º',
            'grade_level' => '8.º',
        ]);

        Storage::disk('public')->delete($workshop->image_path);
        Storage::disk('public')->delete(
            str($workshop->curricularDocuments()->firstOrFail()->file_path)->after('storage/')->toString(),
        );
    }
}
