@extends('layouts.admin')
@section('title', 'Despliegue controlado')
@section('content')
<div class="page-heading">
    <div><h1><i class="fa-brands fa-github"></i> Despliegue controlado</h1><p class="muted">Mantenimiento, validación y reversión segura mediante GitHub Actions.</p></div>
    <div class="actions">
        <a class="button ghost" href="{{ route('admin.gitops.index') }}"><i class="fa-solid fa-arrows-rotate"></i> Consultar GitHub</a>
        <form method="POST" action="{{ route('admin.gitops.validate') }}">@csrf<button class="button secondary"><i class="fa-solid fa-heart-pulse"></i> Validar servicio</button></form>
    </div>
</div>

@if($integrationError)<div class="alert error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $integrationError }}</div>@endif

<section class="split-grid">
    <article class="card">
        <div class="page-heading"><div><h2><i class="fa-solid fa-server"></i> Servicio</h2><p class="muted">Estado efectivo de producción.</p></div>
            <span class="badge {{ $production['http'] === 200 && $production['database'] ? 'success' : 'danger' }}"><span class="status-dot {{ $production['http'] === 200 ? 'success' : 'danger' }}"></span>{{ $production['http'] === 200 ? 'Activo' : 'Con alerta' }}</span>
        </div>
        <dl class="definition-list">
            <dt>HTTP</dt><dd>{{ $production['http'] ?: 'Sin respuesta' }} · {{ $production['latency_ms'] }} ms</dd>
            <dt>Base de datos</dt><dd>{{ $production['database'] ? 'Conectada' : 'Error' }}</dd>
            <dt>Versión</dt><dd><strong>v{{ $production['version'] }}</strong></dd>
            <dt>Referencia</dt><dd>{{ $production['ref'] }}</dd>
            <dt>Commit</dt><dd><code>{{ $production['commit'] ? substr($production['commit'], 0, 8) : 'Anterior al registro' }}</code></dd>
            <dt>Último despliegue</dt><dd>{{ $production['deployed_at'] ?: 'Sin registro' }}</dd>
        </dl>
    </article>
    <article class="card">
        <div class="page-heading"><div><h2><i class="fa-solid fa-cloud"></i> Repositorio remoto</h2><p class="muted">GitHub es la fuente de verdad.</p></div></div>
        <dl class="definition-list">
            <dt>Repositorio</dt><dd>{{ $settings->repository ?: 'Pendiente' }}</dd>
            <dt>Rama</dt><dd>{{ $settings->branch }}</dd>
            <dt>Workflow</dt><dd>{{ $settings->workflow }}</dd>
            <dt>Remoto</dt><dd>{{ $remote['default_branch'] ?? 'No disponible' }}</dd>
            <dt>Runner</dt><dd>@php($runner = collect($runners)->firstWhere('name', 'ctprgv-production'))<span class="badge {{ ($runner['status'] ?? null) === 'online' ? 'success' : 'warning' }}">{{ $runner['status'] ?? 'No visible' }}</span></dd>
            <dt>Integridad</dt><dd>{{ $production['commit'] && (($commits[0]['sha'] ?? null) === $production['commit']) ? 'Sincronizado con la rama' : 'Versión distinta a la punta remota' }}</dd>
            <dt>Versiones nuevas</dt><dd>@if($availableTags->isNotEmpty())<span class="badge warning">{{ $availableTags->count() }} disponible(s)</span> · más reciente <strong>{{ $latestTag['name'] }}</strong>@else<span class="badge success">Producción al día</span>@endif</dd>
        </dl>
    </article>
</section>

<section class="card gitops-flow" style="margin-top:1rem">
    @php($lastValidation = $events->firstWhere('action', 'production_validate'))
    <div class="gitops-flow-heading"><div><h2><i class="fa-solid fa-list-check"></i> Operaciones</h2><p class="muted">Consulta, despliegue y salud de producción.</p></div><span class="badge {{ $production['http'] === 200 ? 'success' : 'danger' }}">HTTP {{ $production['http'] ?: 'sin respuesta' }}</span></div>
    <div class="gitops-steps">
        <article class="gitops-step">
            <div class="gitops-step-title"><span class="gitops-step-number">1</span><strong>Consultar remoto</strong><span class="badge {{ $integrationError ? 'danger' : 'success' }}">{{ $integrationError ? 'Error' : 'Actualizado' }}</span></div>
            <p>{{ count($commits) }} commits · {{ count($tags) }} versiones · {{ count($runs) }} ejecuciones</p>
            <a class="button ghost" href="{{ route('admin.gitops.index') }}"><i class="fa-solid fa-cloud-arrow-down"></i> Actualizar estado</a>
        </article>
        <article class="gitops-step">
            <div class="gitops-step-title"><span class="gitops-step-number">2</span><strong>Aplicar versión</strong><span class="badge {{ $canDispatch ? 'success' : 'warning' }}">{{ $canDispatch ? 'Disponible' : 'Inactivo' }}</span></div>
            <p>Producción: <strong>v{{ $production['version'] }}</strong>@if($latestTag) · disponible: <strong>{{ $latestTag['name'] }}</strong>@endif</p>
            @if(auth()->user()->hasPermission('gitops.deploy'))
                <form class="gitops-version-form" method="POST" action="{{ route('admin.gitops.dispatch') }}" onsubmit="return confirm('¿Aplicar la versión seleccionada en producción?')">@csrf
                    <label for="deploy_target_ref">Versión objetivo</label>
                    <select id="deploy_target_ref" name="target_ref" required>
                        <option value="">Seleccione una versión…</option>
                        @foreach($availableTags->reverse() as $tag)<option value="{{ $tag['name'] }}">{{ $tag['name'] }} · {{ substr($tag['commit']['sha'] ?? '', 0, 8) }}</option>@endforeach
                        <option value="{{ $settings->branch }}">{{ $settings->branch }} · última versión de la rama</option>
                    </select>
                    <button class="button secondary" @disabled(!$canDispatch)><i class="fa-solid fa-rocket"></i> Aplicar versión</button>
                </form>
            @endif
        </article>
        <article class="gitops-step">
            <div class="gitops-step-title"><span class="gitops-step-number">3</span><strong>Validar servicio</strong><span class="badge {{ $production['http'] === 200 && $production['database'] ? 'success' : 'danger' }}">{{ $production['http'] === 200 && $production['database'] ? 'Saludable' : 'Alerta' }}</span></div>
            <p>@if($lastValidation)Última: {{ $lastValidation->message }}@else HTTP {{ $production['http'] }} · BD {{ $production['database'] ? 'OK' : 'ERROR' }}@endif</p>
            <form method="POST" action="{{ route('admin.gitops.validate') }}">@csrf<button class="button"><i class="fa-solid fa-heart-pulse"></i> Ejecutar validación</button></form>
        </article>
    </div>
</section>

@if(auth()->user()->hasPermission('gitops.rollback'))
<section class="card" style="margin-top:1rem">
    <div class="page-heading"><div><h2><i class="fa-solid fa-clock-rotate-left"></i> Revertir despliegue</h2><p class="muted">Regresa a un tag publicado. El workflow crea un respaldo antes de aplicar la versión.</p></div></div>
    <form method="POST" action="{{ route('admin.gitops.rollback') }}" onsubmit="return confirm('Esta operación cambiará producción. ¿Continuar?')">@csrf
        <div class="field-grid">
            <div class="field"><label for="target_ref">Versión destino</label><select id="target_ref" name="target_ref" required><option value="">Seleccione una versión…</option>@foreach($tags as $tag)<option value="{{ $tag['name'] }}">{{ $tag['name'] }} · {{ substr($tag['commit']['sha'] ?? '', 0, 8) }}</option>@endforeach</select></div>
            <div class="field"><label for="confirmation">Confirmación</label><input id="confirmation" name="confirmation" placeholder="Escribe REVERTIR" autocomplete="off" required></div>
        </div>
        <button class="button danger"><i class="fa-solid fa-rotate-left"></i> Revertir a la versión seleccionada</button>
    </form>
</section>
@endif

<section class="split-grid" style="margin-top:1rem">
    <article class="card"><div class="page-heading"><div><h2><i class="fa-solid fa-code-commit"></i> Versiones recientes</h2></div></div>
        <div class="table-wrap"><table><thead><tr><th>Commit</th><th>Mensaje</th><th>Fecha</th></tr></thead><tbody>
        @forelse($commits as $commit)<tr><td><code>{{ substr($commit['sha'], 0, 8) }}</code></td><td>{{ $commit['commit']['message'] ?? '—' }}</td><td>{{ isset($commit['commit']['author']['date']) ? \Illuminate\Support\Carbon::parse($commit['commit']['author']['date'])->format('d/m/Y H:i') : '—' }}</td></tr>@empty<tr><td colspan="3">No disponible.</td></tr>@endforelse
        </tbody></table></div>
    </article>
    <article class="card"><div class="page-heading"><div><h2><i class="fa-solid fa-gears"></i> Ejecuciones</h2></div></div>
        <div class="table-wrap"><table><thead><tr><th>Estado</th><th>Rama</th><th>Fecha</th><th></th></tr></thead><tbody>
        @forelse($runs as $run) @php($state = ($run['conclusion'] ?? null) === 'success' ? 'success' : (($run['status'] ?? null) === 'completed' ? 'danger' : 'warning'))
        <tr><td><span class="badge {{ $state }}">{{ $run['conclusion'] ?? $run['status'] }}</span></td><td>{{ $run['head_branch'] ?? '—' }}</td><td>{{ \Illuminate\Support\Carbon::parse($run['created_at'])->format('d/m/Y H:i') }}</td><td><a href="{{ $run['html_url'] }}" target="_blank" rel="noopener">Abrir</a>@if(($run['status'] ?? null) !== 'completed' && auth()->user()->hasPermission('gitops.deploy')) <form style="display:inline" method="POST" action="{{ route('admin.gitops.cancel', $run['id']) }}">@csrf<button class="button link">Cancelar</button></form>@endif</td></tr>
        @empty<tr><td colspan="4">No hay ejecuciones.</td></tr>@endforelse
        </tbody></table></div>
    </article>
</section>

<section class="card" style="margin-top:1rem"><div class="page-heading"><div><h2><i class="fa-solid fa-clipboard-list"></i> Bitácora GitOps</h2></div></div>
<div class="table-wrap"><table><thead><tr><th>Fecha</th><th>Usuario</th><th>Operación</th><th>Referencia</th><th>Resultado</th><th>Detalle</th></tr></thead><tbody>
@forelse($events as $event)<tr><td>{{ $event->created_at->format('d/m/Y H:i:s') }}</td><td>{{ $event->user?->name ?? 'Sistema' }}</td><td>{{ $event->action }}</td><td>{{ $event->git_ref ?: '—' }}</td><td><span class="badge {{ in_array($event->status, ['accepted','ok']) ? 'success' : 'danger' }}">{{ $event->status }}</span></td><td>{{ $event->message }}</td></tr>@empty<tr><td colspan="6">Sin operaciones registradas.</td></tr>@endforelse
</tbody></table></div></section>

@if(auth()->user()->hasPermission('settings.manage'))
<section class="card" style="margin-top:1rem"><div class="page-heading"><div><h2><i class="fa-solid fa-sliders"></i> Configuración del repositorio</h2><p class="muted">El token permanece cifrado y nunca se muestra.</p></div></div>
<form method="POST" action="{{ route('admin.gitops.settings.update') }}">@csrf @method('PUT')<div class="field-grid">
<div class="field"><label>Repositorio</label><input name="repository" value="{{ old('repository',$settings->repository) }}" required></div><div class="field"><label>Rama</label><input name="branch" value="{{ old('branch',$settings->branch) }}" required></div><div class="field"><label>Workflow</label><input name="workflow" value="{{ old('workflow',$settings->workflow) }}" required></div><div class="field"><label>Reemplazar token</label><input type="password" name="token" autocomplete="new-password" placeholder="{{ filled($settings->token) ? 'Configurado; vacío para conservar' : 'Pendiente' }}"></div>
</div><button class="button secondary"><i class="fa-solid fa-floppy-disk"></i> Guardar configuración</button></form></section>
@endif
@endsection
