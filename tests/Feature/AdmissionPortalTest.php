<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\Event;
use App\Models\InstitutionalDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdmissionPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_portal_combines_managed_content_schedule_and_documents(): void
    {
        $this->assertDatabaseHas('content_pages', [
            'route_name' => 'admission',
            'status' => 'published',
            'is_system' => true,
        ]);
        $this->assertSame(7, Event::where('slug', 'like', 'ctprgv-admision-2027-%')->count());
        $this->assertSame(3, InstitutionalDocument::whereIn('slug', [
            'circular-prematricula-setimo-2027',
            'circular-reglamento-admision-2027',
            'reglamento-admision-matricula-2027',
        ])->count());

        $this->get(route('admission'))
            ->assertOk()
            ->assertSee('Prematrícula para 7.º')
            ->assertSee('Elección de especialidad para 10.º')
            ->assertSee('Prueba de admisión para 7.º')
            ->assertSee('Circulares y reglamento')
            ->assertSee('circular-prematricula-setimo-2027.pdf')
            ->assertDontSee('₡3.000')
            ->assertDontSee('₡4.000');
    }

    public function test_admission_documents_are_bundled_and_publicly_addressable(): void
    {
        $documents = InstitutionalDocument::where('file_path', 'like', 'public:%')->get();

        $this->assertCount(3, $documents);
        foreach ($documents as $document) {
            $this->assertTrue($document->isBundledFile());
            $this->assertStringStartsWith(url('/documentos/admision/'), $document->publicUrl());
            $this->assertFileExists(public_path(substr($document->file_path, 7)));
        }
    }

    public function test_admission_intro_remains_editable_from_page_management(): void
    {
        $page = ContentPage::where('route_name', 'admission')->firstOrFail();

        $this->assertTrue($page->is_system);
        $this->assertSame('Admisión y matrícula 2027', $page->title);
    }

    public function test_admission_hero_keeps_a_readable_title(): void
    {
        $css = file_get_contents(public_path('css/site.css'));

        $this->assertMatchesRegularExpression('/\\.admission-hero h1\\s*\\{[^}]*color:\\s*#fff;/s', $css);
        $this->assertStringContainsString('font-size: clamp(2.6rem, 5vw, 4.8rem)', $css);
    }
}
