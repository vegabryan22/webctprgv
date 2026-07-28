<?php

namespace Tests\Feature;

use App\Models\ExploratoryWorkshop;
use App\Models\Role;
use App\Models\SiteSection;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_editor_can_see_and_update_quick_site_status_panel(): void
    {
        $editor = $this->editor();

        $this->actingAs($editor)
            ->get(route('admin.site-sections.index'))
            ->assertOk()
            ->assertSee('Estado del sitio')
            ->assertSee('Junta Administrativa')
            ->assertSee('Contacto')
            ->assertSee('Noticias');

        $active = SiteSection::whereNotIn('key', ['board', 'contact', 'news'])->pluck('key')->all();
        $this->actingAs($editor)
            ->put(route('admin.site-sections.update'), [
                'active' => $active,
                'maintenance_title' => 'Estamos preparando el sitio',
                'maintenance_message' => 'Estamos revisando el contenido.',
            ])
            ->assertSessionHas('success');

        $this->assertFalse(SiteSection::where('key', 'board')->firstOrFail()->is_active);
        $this->assertFalse(SiteSection::where('key', 'contact')->firstOrFail()->is_active);
        $this->assertFalse(SiteSection::where('key', 'news')->firstOrFail()->is_active);
    }

    public function test_inactive_section_disappears_from_navigation_and_returns_not_found(): void
    {
        SiteSection::where('key', 'board')->update(['is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('JUNTA ADMINISTRATIVA');
        $this->get('/junta-administrativa')->assertNotFound();
        $this->get('/contacto')->assertOk();
    }

    public function test_document_library_avoids_the_public_documents_directory_collision(): void
    {
        $this->assertSame('/biblioteca-documental', route('documents', absolute: false));
        $this->get('/biblioteca-documental')->assertOk()->assertSee('Biblioteca');
    }

    public function test_admission_portal_can_be_disabled_from_the_quick_panel(): void
    {
        SiteSection::where('key', 'admission')->update(['is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('ADMISIÓN');
        $this->get('/admision-y-matricula')->assertNotFound();
    }

    public function test_specialty_and_workshop_can_be_deactivated_without_deletion(): void
    {
        $admin = $this->superAdmin();
        $specialty = Specialty::published()->firstOrFail();
        $workshop = ExploratoryWorkshop::published()->firstOrFail();

        $this->actingAs($admin)->put(route('admin.specialties.toggle', $specialty))->assertSessionHas('success');
        $this->actingAs($admin)->put(route('admin.workshops.toggle', $workshop))->assertSessionHas('success');

        $this->assertSame('published', $specialty->fresh()->status);
        $this->assertSame('published', $workshop->fresh()->status);
        $this->assertFalse($specialty->fresh()->is_active);
        $this->assertFalse($workshop->fresh()->is_active);
        $this->assertTrue(Specialty::published()->whereKey($specialty)->exists());
        $this->assertTrue(ExploratoryWorkshop::published()->whereKey($workshop)->exists());
        $this->get(route('specialties'))->assertOk()->assertDontSee($specialty->name);
        $this->get(route('workshops'))->assertOk()->assertDontSee($workshop->name);
        $this->get(route('specialties.show', $specialty))->assertNotFound();
        $this->get(route('workshops.show', $workshop))->assertNotFound();

        $this->actingAs($admin)->put(route('admin.specialties.toggle', $specialty))->assertSessionHas('success');
        $this->actingAs($admin)->put(route('admin.workshops.toggle', $workshop))->assertSessionHas('success');

        $this->assertTrue($specialty->fresh()->is_active);
        $this->assertTrue($workshop->fresh()->is_active);
        $this->get(route('specialties.show', $specialty))->assertOk();
        $this->get(route('workshops.show', $workshop))->assertOk();
    }

    public function test_draft_cannot_be_activated_as_a_replacement_for_publishing(): void
    {
        $admin = $this->superAdmin();
        $specialty = Specialty::create([
            'name' => 'Especialidad en preparación',
            'slug' => 'especialidad-en-preparacion',
            'grade_levels' => '10.º, 11.º y 12.º',
            'status' => 'draft',
        ]);
        $workshop = ExploratoryWorkshop::create([
            'name' => 'Taller en preparación',
            'slug' => 'taller-en-preparacion',
            'grade_level' => '7.º',
            'summary' => 'Contenido pendiente de publicación.',
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.specialties.toggle', $specialty))
            ->assertSessionHas('error');
        $this->actingAs($admin)
            ->put(route('admin.workshops.toggle', $workshop))
            ->assertSessionHas('error');

        $this->assertSame('draft', $specialty->fresh()->status);
        $this->assertSame('draft', $workshop->fresh()->status);
    }

    public function test_curricular_admin_lists_separate_publication_and_visibility(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)
            ->get(route('admin.specialties.index'))
            ->assertOk()
            ->assertSee('Publicación')
            ->assertSee('Visibilidad')
            ->assertSee('Ocultar del sitio')
            ->assertSee('icon-action');

        $this->actingAs($admin)
            ->get(route('admin.workshops.index'))
            ->assertOk()
            ->assertSee('Publicación')
            ->assertSee('Visibilidad')
            ->assertSee('Ocultar del sitio')
            ->assertSee('icon-action');

        $css = file_get_contents(public_path('css/admin.css'));
        $this->assertStringContainsString('.curricular-admin-table', $css);
        $this->assertStringContainsString('@media (max-width: 720px)', $css);
    }

    private function editor(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->firstOrFail());

        return $user;
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
