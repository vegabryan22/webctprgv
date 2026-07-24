<?php

namespace Tests\Feature;

use App\Models\DirectoryEntry;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_directory_starts_without_unconfirmed_contacts(): void
    {
        $this->get('/directorio')->assertOk()->assertSee('Directorio pendiente de confirmación');
    }

    public function test_only_published_contacts_are_visible_and_searchable(): void
    {
        DirectoryEntry::create(['department' => 'Secretaría', 'position' => 'Atención', 'phone' => '2215-1100', 'status' => 'published', 'verified_at' => now(), 'published_at' => now()]);
        DirectoryEntry::create(['department' => 'Dirección', 'phone' => '2222-2222', 'status' => 'draft']);
        $this->get('/directorio?q=Secretaría')->assertSee('2215-1100')->assertDontSee('2222-2222');
        $this->get('/directorio?q=Biblioteca')->assertSee('No se encontraron contactos');
    }

    public function test_publishing_requires_verification_date(): void
    {
        $this->actingAs($this->superAdmin())->post(route('admin.directory.store'), [
            'department' => 'Secretaría', 'phone' => '2215-1100', 'status' => 'published', 'sort_order' => 0,
        ])->assertSessionHasErrors('verified_at');
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'super-admin')->firstOrFail());

        return $user;
    }
}
