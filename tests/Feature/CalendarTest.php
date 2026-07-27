<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_calendar_and_categories_are_seeded(): void
    {
        $this->assertSame(7, EventCategory::count());
        $this->assertSame(24, Event::where('slug', 'like', 'mep-etp-2026-%')->count());
        $this->assertSame(56, Event::where('slug', 'like', 'ctprgv-2026-%')->count());
        $this->assertSame(13, Event::where('slug', 'like', 'mep-acad-2026-%')->count());
        $this->assertTrue(Event::where('slug', 'mep-acad-2026-inicio-lecciones')->firstOrFail()->is_tentative);
        $this->assertSame(7, Event::where('slug', 'like', 'ctprgv-admision-2027-%')->count());
        $this->assertDatabaseHas('events', [
            'slug' => 'ctprgv-admision-2027-prueba',
            'starts_at' => '2026-09-17 07:30:00',
            'ends_at' => '2026-09-17 10:00:00',
            'source_reference' => 'Circular DRED-SCE07-CTPRGV-D-206-2026',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('events', [
            'slug' => 'mep-etp-2026-expotecnica-nacional',
            'starts_at' => '2026-11-23 00:00:00',
            'status' => 'published',
        ]);
        $this->get('/calendario')
            ->assertOk()
            ->assertSee('Calendario de actividades')
            ->assertSee('Las fechas del MEP son tentativas')
            ->assertSee(now()->locale('es')->translatedFormat('F Y'))
            ->assertSee('class="nav-toggle"', false);
    }

    public function test_seventh_grade_admission_schedule_avoids_unconfirmed_amounts(): void
    {
        $events = Event::where('slug', 'like', 'ctprgv-admision-2027-%')->get();
        $content = $events->pluck('description')->implode(' ');

        $this->assertStringNotContainsString('₡3.000', $content);
        $this->assertStringNotContainsString('₡4.000', $content);
        $this->assertStringNotContainsString('I periodo 2025', $content);
        $this->get('/calendario?month=2026-09')
            ->assertOk()
            ->assertSee('Prueba de admisión para 7.º')
            ->assertSee('Análisis del proceso de admisión de 7.º');
    }

    public function test_published_event_appears_and_can_be_exported(): void
    {
        $event = $this->event(['title' => 'Feria técnica institucional', 'slug' => 'feria-tecnica']);

        $this->get('/calendario?month='.$event->starts_at->format('Y-m'))->assertSee('Feria técnica institucional');
        $this->get(route('calendar.show', $event))->assertOk()->assertSee('Feria técnica institucional');
        $this->get(route('calendar.ical', $event))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->assertSee('BEGIN:VCALENDAR')
            ->assertSee('SUMMARY:Feria técnica institucional');
    }

    public function test_draft_event_is_not_public(): void
    {
        $event = $this->event(['status' => 'draft', 'published_at' => null]);

        $this->get(route('calendar.show', $event))->assertNotFound();
    }

    public function test_super_admin_can_create_activity(): void
    {
        $category = EventCategory::firstOrFail();

        $this->actingAs($this->superAdmin())->post(route('admin.events.store'), [
            'event_category_id' => $category->id,
            'title' => 'Reunión de familias',
            'slug' => 'reunion-familias',
            'starts_at' => now()->addDays(5)->format('Y-m-d H:i:s'),
            'audience' => 'families',
            'status' => 'published',
        ])->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', ['slug' => 'reunion-familias', 'status' => 'published']);
    }

    public function test_activity_list_uses_compact_spanish_pagination(): void
    {
        $this->get('/calendario/actividades')
            ->assertOk()
            ->assertSee('Paginación de actividades')
            ->assertSee('Mostrando 1–15 de')
            ->assertSee('Siguiente')
            ->assertDontSee('Showing 1 to 15');
    }

    public function test_admin_activity_list_uses_compact_spanish_pagination(): void
    {
        $this->actingAs($this->superAdmin())->get('/administracion/actividades')
            ->assertOk()
            ->assertSee('Paginación de resultados')
            ->assertSee('Mostrando 1–20 de 100 resultados')
            ->assertSee('Siguiente')
            ->assertDontSee('Showing 1 to 20')
            ->assertDontSee('<svg', false);
    }

    private function event(array $attributes = []): Event
    {
        return Event::create(array_merge([
            'event_category_id' => EventCategory::firstOrFail()->id,
            'title' => 'Actividad de prueba',
            'slug' => 'actividad-prueba',
            'starts_at' => now()->addWeek(),
            'all_day' => false,
            'audience' => 'general',
            'status' => 'published',
            'published_at' => now(),
        ], $attributes));
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
