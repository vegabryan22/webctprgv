<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\NavigationItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_existing_pages_and_menu_are_imported(): void
    {
        $this->assertSame(7, ContentPage::where('is_system', true)->count());
        $this->assertSame(9, NavigationItem::count());
        $this->assertDatabaseHas('content_pages', ['route_name' => 'home', 'status' => 'published']);
        $this->assertDatabaseHas('navigation_items', ['route_name' => 'contact', 'label' => 'CONTACTO']);
        $this->assertDatabaseHas('navigation_items', ['route_name' => 'board', 'label' => 'JUNTA ADMINISTRATIVA']);
        $this->assertDatabaseHas('navigation_items', ['route_name' => 'calendar.index', 'label' => 'CALENDARIO']);
        $this->assertDatabaseHas('navigation_items', ['route_name' => 'services.index', 'label' => 'SERVICIOS']);
    }

    public function test_database_content_is_rendered_on_existing_route(): void
    {
        ContentPage::where('route_name', 'information')->update(['content' => '<main>Contenido editable desde MySQL</main>']);

        $this->get('/informacion')->assertOk()->assertSee('Contenido editable desde MySQL');
    }

    public function test_home_uses_managed_title_and_structured_dynamic_information(): void
    {
        ContentPage::where('route_name', 'home')->update([
            'title' => 'Portada administrable',
            'content' => '<main>Contenido heredado del inicio</main>',
        ]);
        Event::query()->delete();
        $event = Event::create([
            'event_category_id' => EventCategory::firstOrFail()->id,
            'title' => 'Actividad institucional próxima',
            'slug' => 'actividad-institucional-proxima',
            'starts_at' => now()->addWeek(),
            'all_day' => true,
            'audience' => 'general',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Portada administrable')
            ->assertDontSee('Contenido heredado del inicio')
            ->assertSee('¿Qué necesita consultar?')
            ->assertSee('Actividad institucional próxima')
            ->assertSee(route('calendar.show', $event));
    }

    public function test_home_does_not_show_draft_activities(): void
    {
        Event::create([
            'event_category_id' => EventCategory::firstOrFail()->id,
            'title' => 'Actividad interna no publicada',
            'slug' => 'actividad-interna-no-publicada',
            'starts_at' => now()->addWeek(),
            'all_day' => true,
            'audience' => 'general',
            'status' => 'draft',
        ]);

        $this->get('/')->assertOk()->assertDontSee('Actividad interna no publicada');
    }

    public function test_system_page_cannot_be_deleted(): void
    {
        $page = ContentPage::where('route_name', 'home')->firstOrFail();

        $this->actingAs($this->superAdmin())
            ->delete(route('admin.pages.destroy', $page))
            ->assertStatus(422);

        $this->assertDatabaseHas('content_pages', ['id' => $page->id]);
    }

    public function test_menu_can_be_renamed_and_reordered(): void
    {
        $item = NavigationItem::where('route_name', 'news')->firstOrFail();

        $this->actingAs($this->superAdmin())->put(route('admin.navigation.update', $item), [
            'label' => 'ACTUALIDAD',
            'route_name' => 'news',
            'sort_order' => 5,
            'is_active' => 1,
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('navigation_items', ['id' => $item->id, 'label' => 'ACTUALIDAD', 'sort_order' => 5]);
        $this->get('/')->assertSee('ACTUALIDAD');
    }

    private function superAdmin(): User
    {
        $role = Role::where('name', 'super-admin')->firstOrFail();
        $user = User::factory()->create();
        $user->roles()->attach($role);

        return $user;
    }
}
