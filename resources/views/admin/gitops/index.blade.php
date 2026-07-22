@extends('layouts.admin')

@section('title', 'GitHub GitOps')

@section('content')
<div class="page-heading">
    <div>
        <h1><i class="fa-brands fa-github"></i> GitHub GitOps</h1>
        <p class="muted">Visibilidad del código, automatizaciones y despliegues del sitio.</p>
    </div>
    @if(auth()->user()->hasPermission('gitops.deploy'))
        <form method="POST" action="{{ route('admin.gitops.dispatch') }}" onsubmit="return confirm('¿Solicitar el despliegue de {{ config('gitops.branch') }} mediante {{ config('gitops.workflow') }}?')">
            @csrf
            <button class="button secondary" type="submit" @disabled(!$canDispatch)>
                <i class="fa-solid fa-rocket"></i> Solicitar despliegue
            </button>
        </form>
    @endif
</div>

@if(!$configured)
    <div class="alert error"><i class="fa-solid fa-circle-info"></i> La integración remota aún no está configurada. Defina <code>GITHUB_REPOSITORY</code> y <code>GITHUB_TOKEN</code> en <code>.env</code>.</div>
@elseif($integrationError)
    <div class="alert error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $integrationError }}</div>
@endif

<section class="split-grid">
    <article class="card">
        <div class="page-heading">
            <div><h2><i class="fa-solid fa-code-branch"></i> Repositorio local</h2><p class="muted">Estado del código que ejecuta esta instancia.</p></div>
            <span class="badge {{ $repository['clean'] ? 'success' : 'warning' }}"><span class="status-dot {{ $repository['clean'] ? 'success' : 'warning' }}"></span>{{ $repository['clean'] ? 'Limpio' : 'Con cambios' }}</span>
        </div>
        <dl class="definition-list">
            <dt>Rama</dt><dd><i class="fa-solid fa-code-branch"></i> {{ $repository['branch'] }}</dd>
            <dt>Commit</dt><dd><code>{{ $repository['commit'] }}</code> · {{ $repository['message'] }}</dd>
            <dt>Autor</dt><dd>{{ $repository['author'] }}</dd>
            <dt>Fecha</dt><dd>{{ $repository['date'] }}</dd>
            <dt>Remoto</dt><dd>{{ $repository['remote'] ?: 'No configurado' }}</dd>
        </dl>
    </article>

    <article class="card">
        <div class="page-heading"><div><h2><i class="fa-solid fa-cloud-arrow-up"></i> Integración remota</h2><p class="muted">Configuración efectiva, sin revelar el token.</p></div></div>
        <dl class="definition-list">
            <dt>Repositorio</dt><dd>{{ config('gitops.repository') ?: 'Pendiente' }}</dd>
            <dt>Rama objetivo</dt><dd>{{ config('gitops.branch') }}</dd>
            <dt>Workflow</dt><dd>{{ config('gitops.workflow') }}</dd>
            <dt>Token</dt><dd><span class="badge {{ filled(config('gitops.token')) ? 'success' : 'warning' }}">{{ filled(config('gitops.token')) ? 'Configurado' : 'Pendiente' }}</span></dd>
            <dt>Despliegue</dt><dd><span class="badge {{ $canDispatch ? 'success' : 'neutral' }}">{{ $canDispatch ? 'Disponible' : 'Inactivo' }}</span></dd>
        </dl>
    </article>
</section>

<section class="card" style="margin-top: 1rem">
    <div class="page-heading"><div><h2><i class="fa-solid fa-clock-rotate-left"></i> Commits recientes</h2><p class="muted">Historial local de la rama actual.</p></div></div>
    <div class="table-wrap"><table><thead><tr><th>Commit</th><th>Fecha</th><th>Autor</th><th>Mensaje</th></tr></thead><tbody>
        @foreach($repository['commits'] as $commit)<tr><td><code>{{ $commit['hash'] }}</code></td><td>{{ $commit['date'] }}</td><td>{{ $commit['author'] }}</td><td>{{ $commit['message'] }}</td></tr>@endforeach
    </tbody></table></div>
</section>

<section class="card" style="margin-top: 1rem">
    <div class="page-heading"><div><h2><i class="fa-solid fa-gears"></i> GitHub Actions</h2><p class="muted">Últimas ejecuciones reportadas por GitHub.</p></div></div>
    <div class="table-wrap"><table><thead><tr><th>Workflow</th><th>Rama</th><th>Estado</th><th>Evento</th><th>Fecha</th><th></th></tr></thead><tbody>
        @forelse($runs as $run)
            @php($state = ($run['conclusion'] ?? null) === 'success' ? 'success' : (($run['status'] ?? null) === 'completed' ? 'danger' : 'warning'))
            <tr><td>{{ $run['name'] ?? 'Workflow' }}</td><td>{{ $run['head_branch'] ?? '—' }}</td><td><span class="badge {{ $state }}">{{ $run['conclusion'] ?? $run['status'] ?? 'desconocido' }}</span></td><td>{{ $run['event'] ?? '—' }}</td><td>{{ isset($run['created_at']) ? \Illuminate\Support\Carbon::parse($run['created_at'])->format('d/m/Y H:i') : '—' }}</td><td>@if(isset($run['html_url']))<a class="button link" href="{{ $run['html_url'] }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-arrow-up-right-from-square"></i> Abrir</a>@endif</td></tr>
        @empty<tr><td colspan="6">No hay ejecuciones disponibles.</td></tr>@endforelse
    </tbody></table></div>
</section>

<section class="card" style="margin-top: 1rem">
    <div class="page-heading"><div><h2><i class="fa-solid fa-clipboard-list"></i> Bitácora de operaciones</h2><p class="muted">Intentos de despliegue solicitados desde este panel.</p></div></div>
    <div class="table-wrap"><table><thead><tr><th>Fecha</th><th>Usuario</th><th>Acción</th><th>Referencia</th><th>Resultado</th><th>Detalle</th></tr></thead><tbody>
        @forelse($events as $event)<tr><td>{{ $event->created_at->format('d/m/Y H:i') }}</td><td>{{ $event->user?->name ?? 'Sistema' }}</td><td>{{ $event->action }}</td><td>{{ $event->git_ref }}</td><td><span class="badge {{ $event->status === 'accepted' ? 'success' : 'danger' }}">{{ $event->status }}</span></td><td>{{ $event->message }} @if($event->external_url)<a href="{{ $event->external_url }}" target="_blank" rel="noopener noreferrer">Ver</a>@endif</td></tr>
        @empty<tr><td colspan="6">No se han solicitado operaciones.</td></tr>@endforelse
    </tbody></table></div>
</section>
@endsection
