<?php

namespace Tests\Feature;

use App\Models\InstitutionalService;
use App\Models\Role;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_catalog_starts_without_unconfirmed_demonstration_services(): void
    {
        $this->get('/servicios')->assertOk()->assertSee('Servicios pendientes de confirmación');
    }

    public function test_only_published_services_are_visible(): void
    {
        $published = $this->service(['name' => 'Solicitud de constancia', 'slug' => 'solicitud-constancia']);
        $draft = $this->service(['name' => 'Servicio pendiente', 'slug' => 'servicio-pendiente', 'status' => 'draft', 'published_at' => null]);

        $this->get('/servicios')->assertSee($published->name)->assertDontSee($draft->name);
        $this->get(route('services.show', $published))->assertOk()->assertSee('Secretaría');
        $this->get(route('services.show', $draft))->assertNotFound();
    }

    public function test_super_admin_can_publish_verified_service(): void
    {
        $category = ServiceCategory::firstOrFail();
        $this->actingAs($this->superAdmin())->post(route('admin.services.store'), [
            'service_category_id' => $category->id,
            'name' => 'Certificación de estudios',
            'slug' => 'certificacion-estudios',
            'summary' => 'Solicitud institucional de certificación.',
            'audience' => 'students',
            'responsible' => 'Secretaría',
            'verified_at' => now()->toDateString(),
            'status' => 'published',
            'sort_order' => 10,
        ])->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('institutional_services', ['slug' => 'certificacion-estudios', 'status' => 'published']);
    }

    private function service(array $attributes = []): InstitutionalService
    {
        return InstitutionalService::create(array_merge([
            'service_category_id' => ServiceCategory::firstOrFail()->id,
            'name' => 'Servicio institucional',
            'slug' => 'servicio-institucional',
            'summary' => 'Información confirmada.',
            'audience' => 'general',
            'responsible' => 'Secretaría',
            'status' => 'published',
            'published_at' => now(),
            'sort_order' => 10,
        ], $attributes));
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
