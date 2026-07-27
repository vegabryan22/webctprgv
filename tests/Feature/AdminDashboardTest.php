<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_super_admin_sees_the_operational_summary(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        Event::create([
            'event_category_id' => EventCategory::firstOrFail()->id,
            'author_id' => $admin->id,
            'title' => 'Actividad institucional próxima',
            'slug' => 'actividad-institucional-proxima',
            'summary' => 'Actividad para comprobar la agenda del resumen.',
            'description' => 'Información verificada para la prueba.',
            'starts_at' => now()->addDay()->startOfHour(),
            'all_day' => false,
            'status' => 'published',
            'source' => 'Dirección',
            'published_at' => now(),
        ]);
        ContactMessage::create([
            'name' => 'Persona consultante',
            'email' => 'consulta@example.test',
            'subject' => 'Consulta de matrícula',
            'message' => 'Mensaje de prueba para el tablero.',
            'status' => 'new',
            'consented_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Centro de control')
            ->assertSee('Estado por módulo')
            ->assertSee('Próximas actividades')
            ->assertSee('Actividad institucional próxima')
            ->assertSee('Consultas recientes')
            ->assertSee('Consulta de matrícula')
            ->assertSee('Secciones visibles');
    }

    public function test_dashboard_reports_maintenance_mode(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());
        SiteSetting::where('key', 'maintenance_enabled')->update(['value' => '1']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('En mantenimiento')
            ->assertSee('Acceso para lectores');
    }

    public function test_dashboard_styles_include_responsive_layouts(): void
    {
        $css = file_get_contents(public_path('css/admin.css'));

        $this->assertStringContainsString('.dashboard-overview', $css);
        $this->assertStringContainsString('@media (max-width: 1180px)', $css);
        $this->assertStringContainsString('@media (max-width: 520px)', $css);
        $this->assertStringContainsString('grid-template-columns: 1fr;', $css);
    }
}
