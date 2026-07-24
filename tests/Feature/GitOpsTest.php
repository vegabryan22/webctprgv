<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\GitOpsSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GitOpsTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_gitops_dashboard(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get('/administracion/gitops')
            ->assertOk()
            ->assertSee('GitHub GitOps')
            ->assertSee('Repositorio local');
    }

    public function test_workflow_dispatch_is_sent_and_audited(): void
    {
        config()->set('gitops.repository', 'ctprgv/sitio');
        config()->set('gitops.branch', 'main');
        config()->set('gitops.workflow', 'deploy.yml');
        config()->set('gitops.token', 'token-de-prueba');
        Http::fake([
            'api.github.com/repos/ctprgv/sitio/actions/workflows/deploy.yml/dispatches' => Http::response([
                'html_url' => 'https://github.com/ctprgv/sitio/actions/runs/1',
            ]),
        ]);

        $this->actingAs($this->superAdmin())
            ->post('/administracion/gitops/desplegar')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('git_ops_events', [
            'action' => 'workflow_dispatch',
            'status' => 'accepted',
            'repository' => 'ctprgv/sitio',
        ]);
    }

    public function test_super_admin_can_store_encrypted_gitops_settings(): void
    {
        $this->actingAs($this->superAdmin())
            ->put('/administracion/gitops/configuracion', [
                'repository' => 'vegabryan22/webctprgv',
                'branch' => 'main',
                'workflow' => 'deploy.yml',
                'token' => 'github_pat_secreto',
            ])
            ->assertSessionHas('success');

        $setting = GitOpsSetting::firstOrFail();
        $this->assertSame('github_pat_secreto', $setting->token);
        $this->assertStringNotContainsString('github_pat_secreto', $setting->getRawOriginal('token'));
    }

    private function superAdmin(): User
    {
        $role = Role::create(['name' => 'super-admin', 'display_name' => 'Superadministración']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        return $user;
    }
}
