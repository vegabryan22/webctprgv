<?php

namespace Tests\Feature;

use App\Models\DocumentCategory;
use App\Models\InstitutionalDocument;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DocumentLibraryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_library_starts_with_verified_admission_documents(): void
    {
        $this->get(route('documents'))
            ->assertOk()
            ->assertSee('Admisión y matrícula')
            ->assertSee('Circular de prematrícula de 7.º');
    }

    public function test_expired_replaced_and_draft_documents_are_hidden(): void
    {
        $category = DocumentCategory::first();
        $base = ['document_category_id' => $category->id, 'description' => 'Información', 'file_path' => 'documents/test.pdf', 'original_filename' => 'test.pdf', 'responsible' => 'Dirección', 'audience' => 'general', 'status' => 'published', 'verified_at' => now(), 'published_at' => now()];
        $current = InstitutionalDocument::create(array_merge($base, ['title' => 'Reglamento vigente', 'slug' => 'vigente']));
        InstitutionalDocument::create(array_merge($base, ['title' => 'Documento vencido', 'slug' => 'vencido', 'expires_at' => today()->subDay()]));
        InstitutionalDocument::create(array_merge($base, ['title' => 'Borrador', 'slug' => 'borrador', 'status' => 'draft', 'published_at' => null]));
        $old = InstitutionalDocument::create(array_merge($base, ['title' => 'Documento reemplazado', 'slug' => 'reemplazado']));
        $old->update(['replaced_by_id' => $current->id]);
        $this->get(route('documents'))->assertSee('Reglamento vigente')->assertDontSee('Documento vencido')->assertDontSee('Documento reemplazado')->assertDontSee('Borrador');
    }

    public function test_administrator_can_upload_and_publish_a_verified_document(): void
    {
        $this->actingAs($this->superAdmin())->post(route('admin.documents.store'), [
            'document_category_id' => DocumentCategory::firstOrFail()->id,
            'title' => 'Reglamento institucional',
            'slug' => 'reglamento-institucional',
            'description' => 'Documento oficial vigente.',
            'file' => UploadedFile::fake()->create('reglamento.pdf', 100, 'application/pdf'),
            'version' => '2026',
            'responsible' => 'Dirección',
            'audience' => 'general',
            'issued_at' => today()->toDateString(),
            'status' => 'published',
            'verified_at' => today()->toDateString(),
            'sort_order' => 0,
        ])->assertRedirect(route('admin.documents.index'));

        $document = InstitutionalDocument::where('slug', 'reglamento-institucional')->firstOrFail();
        $storedPath = storage_path('app/public/'.$document->file_path);
        $this->assertFileExists($storedPath);
        $this->get(route('documents'))->assertOk()->assertSee('Reglamento institucional');
        File::delete($storedPath);
    }

    public function test_published_document_requires_verification_date(): void
    {
        $this->actingAs($this->superAdmin())->post(route('admin.documents.store'), [
            'document_category_id' => DocumentCategory::firstOrFail()->id,
            'title' => 'Circular sin verificar',
            'slug' => 'circular-sin-verificar',
            'file' => UploadedFile::fake()->create('circular.pdf', 20, 'application/pdf'),
            'responsible' => 'Dirección',
            'audience' => 'staff',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertSessionHasErrors('verified_at');

        $this->assertDatabaseMissing('institutional_documents', ['slug' => 'circular-sin-verificar']);
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
