<?php

namespace Tests\Feature;

use App\Models\GitOpsSetting;
use App\Models\Role;
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
            ->assertSee('Despliegue controlado')
            ->assertDontSee('Repositorio de trabajo local')
            ->assertSee('Repositorio remoto');
    }

    public function test_local_environment_shows_working_repository(): void
    {
        $this->app->instance('env', 'local');
        Http::fake(['*' => Http::response([], 200)]);

        $this->actingAs($this->superAdmin())
            ->get('/administracion/gitops')
            ->assertOk()
            ->assertSee('Repositorio de trabajo local')
            ->assertSee('Validar Desarrollo');
    }

    public function test_workflow_dispatch_is_sent_and_audited(): void
    {
        config()->set('gitops.repository', 'ctprgv/sitio');
        config()->set('gitops.branch', 'main');
        config()->set('gitops.workflow', 'deploy.yml');
        config()->set('gitops.token', 'token-de-prueba');
        Http::fake([
            'api.github.com/repos/ctprgv/sitio/tags*' => Http::response([['name' => 'v0.13.0', 'commit' => ['sha' => 'abc123']]]),
            'api.github.com/repos/ctprgv/sitio/actions/workflows/deploy.yml/dispatches' => Http::response([
                'html_url' => 'https://github.com/ctprgv/sitio/actions/runs/1',
            ]),
        ]);

        $response = $this->actingAs($this->superAdmin())
            ->post('/administracion/gitops/desplegar', ['target_ref' => 'v0.13.0'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertStringContainsString('monitor_until=', $response->headers->get('Location'));

        $this->assertDatabaseHas('git_ops_events', [
            'action' => 'workflow_dispatch',
            'status' => 'accepted',
            'repository' => 'ctprgv/sitio',
            'git_ref' => 'v0.13.0',
        ]);
        Http::assertSent(fn ($request) => str_contains($request->url(), '/dispatches') && $request['inputs']['target_ref'] === 'v0.13.0');
    }

    public function test_gitops_dashboard_shows_deployment_monitoring_state(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.gitops.index', ['monitor_until' => now()->addMinute()->timestamp]))
            ->assertOk()
            ->assertSee('Despliegue en seguimiento')
            ->assertSee('window.setTimeout', false);
    }

    public function test_deployment_rejects_ref_not_present_on_github(): void
    {
        config()->set('gitops.repository', 'ctprgv/sitio');
        config()->set('gitops.branch', 'main');
        config()->set('gitops.workflow', 'deploy.yml');
        config()->set('gitops.token', 'token-de-prueba');
        Http::fake(['api.github.com/repos/ctprgv/sitio/tags*' => Http::response([])]);

        $this->actingAs($this->superAdmin())
            ->post('/administracion/gitops/desplegar', ['target_ref' => 'v9.9.9'])
            ->assertSessionHasErrors('target_ref');
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

    public function test_rollback_requires_explicit_confirmation(): void
    {
        $this->actingAs($this->superAdmin())
            ->post('/administracion/gitops/revertir', [
                'target_ref' => 'v0.6.0',
                'confirmation' => 'NO',
            ])
            ->assertSessionHasErrors('confirmation');
    }

    public function test_super_admin_can_dispatch_a_tag_rollback(): void
    {
        GitOpsSetting::create([
            'repository' => 'vegabryan22/webctprgv', 'branch' => 'main',
            'workflow' => 'deploy.yml', 'token' => 'token',
        ]);
        Http::fake([
            'api.github.com/repos/vegabryan22/webctprgv/actions/workflows/deploy.yml/dispatches' => Http::response([], 204),
        ]);

        $this->actingAs($this->superAdmin())
            ->post('/administracion/gitops/revertir', [
                'target_ref' => 'v0.6.0', 'confirmation' => 'REVERTIR',
            ])->assertSessionHas('success');

        $this->assertDatabaseHas('git_ops_events', [
            'action' => 'rollback_dispatch', 'git_ref' => 'v0.6.0', 'status' => 'accepted',
        ]);
    }

    private function superAdmin(): User
    {
        $role = Role::create(['name' => 'super-admin', 'display_name' => 'Superadministración']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        return $user;
    }
}
