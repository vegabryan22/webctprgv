<?php

namespace Tests\Feature;

use App\Models\ExploratoryWorkshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExploratoryWorkshopTest extends TestCase
{
    use RefreshDatabase;

    public function test_workshops_and_specialties_are_presented_as_different_grade_paths(): void
    {
        $this->seed();
        $this->get('/talleres-exploratorios')->assertOk()->assertSee('7.º, 8.º y 9.º')->assertSee('Talleres pendientes de confirmación');
        $this->get('/especialidades')->assertOk()->assertSee('10.º, 11.º y 12.º')->assertSee('¿Busca talleres de 7.º, 8.º y 9.º?');
    }

    public function test_only_published_workshops_are_visible(): void
    {
        $this->seed();
        ExploratoryWorkshop::create(['name' => 'Taller confirmado', 'slug' => 'taller-confirmado', 'grade_level' => '7.º', 'summary' => 'Exploración técnica.', 'status' => 'published', 'published_at' => now()]);
        ExploratoryWorkshop::create(['name' => 'Taller borrador', 'slug' => 'taller-borrador', 'grade_level' => '8.º', 'summary' => 'Pendiente.', 'status' => 'draft']);
        $this->get('/talleres-exploratorios')->assertSee('Taller confirmado')->assertDontSee('Taller borrador');
    }
}
