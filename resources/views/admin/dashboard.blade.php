@extends('layouts.admin')

@section('title', 'Resumen')

@section('content')
<div class="dashboard-heading">
    <div>
        <span class="dashboard-eyebrow">Centro de control</span>
        <h1><i class="fa-solid fa-chart-line"></i> Resumen del sitio</h1>
        <p>Revise el estado público, el contenido y las tareas que requieren atención.</p>
    </div>
    <div class="dashboard-heading__meta">
        <span class="dashboard-version"><i class="fa-solid fa-code-branch"></i> v{{ config('version.number') }}</span>
        <span class="dashboard-public-state {{ $overview['maintenance'] ? 'maintenance' : 'online' }}">
            <i class="fa-solid {{ $overview['maintenance'] ? 'fa-person-digging' : 'fa-circle-check' }}"></i>
            {{ $overview['maintenance'] ? 'En mantenimiento' : 'Sitio público' }}
        </span>
    </div>
</div>

<section class="dashboard-overview" aria-label="Indicadores principales">
    <article class="dashboard-stat dashboard-stat--state">
        <div><i class="fa-solid fa-globe"></i></div>
        <span>Estado público</span>
        <strong>{{ $overview['maintenance'] ? 'Revisión privada' : 'En línea' }}</strong>
        @if(auth()->user()->hasPermission('site-sections.manage'))
        <a href="{{ route('admin.site-sections.index') }}">Administrar <i class="fa-solid fa-arrow-right"></i></a>
        @endif
    </article>
    <article class="dashboard-stat">
        <div><i class="fa-solid fa-toggle-on"></i></div>
        <span>Secciones visibles</span>
        <strong>{{ $overview['active_sections'] }} <small>de {{ $overview['total_sections'] }}</small></strong>
        <p>{{ $overview['total_sections'] - $overview['active_sections'] }} desactivadas</p>
    </article>
    <article class="dashboard-stat">
        <div><i class="fa-solid fa-circle-check"></i></div>
        <span>Contenido publicado</span>
        <strong>{{ $overview['published'] }}</strong>
        <p>Registros públicos actuales</p>
    </article>
    <article class="dashboard-stat {{ ($overview['drafts'] + $overview['new_messages']) > 0 ? 'dashboard-stat--attention' : '' }}">
        <div><i class="fa-solid fa-bell"></i></div>
        <span>Requiere atención</span>
        <strong>{{ $overview['drafts'] + $overview['new_messages'] }}</strong>
        <p>{{ $overview['drafts'] }} borradores · {{ $overview['new_messages'] }} consultas nuevas</p>
    </article>
</section>

<section class="dashboard-section">
    <header class="dashboard-section__heading">
        <div><span>Contenido</span><h2>Estado por módulo</h2></div>
        @if(auth()->user()->hasPermission('pages.view'))
        <a href="{{ route('admin.content-audit.index') }}">Abrir revisión editorial <i class="fa-solid fa-arrow-right"></i></a>
        @endif
    </header>
    <div class="dashboard-modules">
        @foreach($modules as $module)
            @if(auth()->user()->hasPermission($module['permission']))
            <a class="dashboard-module" href="{{ route($module['route']) }}" style="--module-color: {{ $module['color'] }}">
                <i class="fa-solid {{ $module['icon'] }}"></i>
                <div><strong>{{ $module['label'] }}</strong><span>{{ $module['published'] }} publicados</span></div>
                @if($module['drafts'] > 0)<em>{{ $module['drafts'] }} borradores</em>@else<i class="fa-solid fa-check dashboard-module__check"></i>@endif
            </a>
            @endif
        @endforeach
    </div>
</section>

<div class="dashboard-columns">
    <section class="dashboard-panel">
        <header class="dashboard-panel__heading">
            <div><span>Agenda</span><h2>Próximas actividades</h2></div>
            @if(auth()->user()->hasPermission('events.view'))<a href="{{ route('admin.events.index') }}">Ver todas</a>@endif
        </header>
        <div class="dashboard-events">
            @forelse($upcomingEvents as $event)
            <article>
                <time datetime="{{ $event->starts_at->toIso8601String() }}"><strong>{{ $event->starts_at->format('d') }}</strong><span>{{ $event->starts_at->translatedFormat('M') }}</span></time>
                <div><strong>{{ $event->title }}</strong><span>{{ $event->all_day ? 'Todo el día' : $event->starts_at->format('H:i') }} · {{ $event->category->name }}</span></div>
            </article>
            @empty
            <div class="dashboard-empty"><i class="fa-regular fa-calendar-check"></i><p>No hay actividades próximas.</p></div>
            @endforelse
        </div>
    </section>

    <section class="dashboard-panel">
        <header class="dashboard-panel__heading">
            <div><span>Atención</span><h2>Consultas recientes</h2></div>
            @if(auth()->user()->hasPermission('contact.manage'))<a href="{{ route('admin.contact-messages.index') }}">Abrir bandeja</a>@endif
        </header>
        @if(auth()->user()->hasPermission('contact.manage'))
        <div class="dashboard-messages">
            @forelse($recentMessages as $message)
            <a href="{{ route('admin.contact-messages.show', $message) }}">
                <span class="dashboard-message-status {{ $message->status }}"></span>
                <div><strong>{{ $message->subject }}</strong><span>{{ $message->name }} · {{ $message->created_at->diffForHumans() }}</span></div>
                <em>{{ match($message->status) { 'new' => 'Nueva', 'read' => 'Leída', 'handled' => 'Atendida', default => 'Archivada' } }}</em>
            </a>
            @empty
            <div class="dashboard-empty"><i class="fa-regular fa-envelope-open"></i><p>No hay consultas recibidas.</p></div>
            @endforelse
        </div>
        @else
        <div class="dashboard-empty"><i class="fa-solid fa-lock"></i><p>Su rol no permite consultar la bandeja.</p></div>
        @endif
    </section>
</div>

<section class="dashboard-footer-summary">
    <div><i class="fa-solid fa-users"></i><span><strong>{{ $overview['users'] }}</strong> usuarios</span></div>
    <div><i class="fa-solid fa-shield-halved"></i><span><strong>{{ $overview['roles'] }}</strong> roles</span></div>
    <p><i class="fa-solid fa-circle-info"></i> Los indicadores muestran el estado actual almacenado en MySQL.</p>
</section>
@endsection
