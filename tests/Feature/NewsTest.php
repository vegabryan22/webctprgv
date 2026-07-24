<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_news_page_replaces_demonstration_content_with_honest_empty_state(): void
    {
        $this->get('/noticias')
            ->assertOk()
            ->assertSee('No hay noticias publicadas')
            ->assertDontSee('Feria Científica')
            ->assertDontSee('Calendario de Actividades');
    }

    public function test_only_current_published_articles_are_public(): void
    {
        $published = $this->article(['title' => 'Comunicado oficial vigente', 'slug' => 'comunicado-vigente']);
        $this->article(['title' => 'Borrador interno', 'slug' => 'borrador-interno', 'status' => 'draft', 'published_at' => null]);
        $expired = $this->article(['title' => 'Comunicado vencido', 'slug' => 'comunicado-vencido', 'expires_at' => now()->subDay()]);

        $this->get('/noticias')
            ->assertSee('Comunicado oficial vigente')
            ->assertDontSee('Borrador interno')
            ->assertDontSee('Comunicado vencido');
        $this->get(route('news.show', $published))->assertOk()->assertSee('Contenido confirmado');
        $this->get(route('news.show', $expired))->assertNotFound();
    }

    public function test_super_admin_can_create_and_publish_news(): void
    {
        $category = NewsCategory::firstOrFail();

        $this->actingAs($this->superAdmin())->post(route('admin.news.store'), [
            'news_category_id' => $category->id,
            'title' => 'Nueva comunicación institucional',
            'slug' => 'nueva-comunicacion-institucional',
            'summary' => 'Resumen oficial de la comunicación.',
            'content' => '<p>Contenido de la comunicación.</p>',
            'status' => 'published',
            'is_featured' => 1,
        ])->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news_articles', [
            'slug' => 'nueva-comunicacion-institucional',
            'status' => 'published',
            'is_featured' => true,
        ]);
    }

    public function test_footer_uses_current_year_and_networks_department_credit(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('© '.now()->year.' Departamento de Redes')
            ->assertSee('Prof. Bryan Vega Rondón y estudiantes de 12.º año');
    }

    private function article(array $attributes = []): NewsArticle
    {
        return NewsArticle::create(array_merge([
            'news_category_id' => NewsCategory::firstOrFail()->id,
            'title' => 'Noticia institucional',
            'slug' => 'noticia-institucional',
            'summary' => 'Resumen confirmado.',
            'content' => '<p>Contenido confirmado</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ], $attributes));
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
