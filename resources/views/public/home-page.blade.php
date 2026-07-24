@extends('layouts.public')

@section('title', $page->title)

@section('content')
{!! $page->content !!}

<section class="home-portal" aria-labelledby="home-portal-title">
    <div class="home-portal__inner">
        <header class="home-portal__header">
            <span class="home-portal__eyebrow">Información útil</span>
            <h2 id="home-portal-title">Encuentre rápidamente lo que necesita</h2>
            <p>Acceda a los servicios y contenidos institucionales más consultados.</p>
        </header>

        <nav class="home-quick-links" aria-label="Accesos rápidos">
            <a href="{{ route('calendar.index') }}"><i class="fas fa-calendar-days" aria-hidden="true"></i><span><strong>Calendario</strong><small>Fechas académicas e institucionales</small></span><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <a href="{{ route('specialties') }}"><i class="fas fa-screwdriver-wrench" aria-hidden="true"></i><span><strong>Especialidades</strong><small>Conozca nuestra oferta técnica</small></span><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <a href="{{ route('information') }}"><i class="fas fa-circle-info" aria-hidden="true"></i><span><strong>Información estudiantil</strong><small>Horarios, admisión y servicios</small></span><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <a href="{{ route('contact') }}"><i class="fas fa-address-book" aria-hidden="true"></i><span><strong>Contacto</strong><small>Ubicación y medios de atención</small></span><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </nav>

        <div class="home-upcoming">
            <div class="home-section-heading">
                <div><span class="home-portal__eyebrow">Agenda institucional</span><h2>Próximas actividades</h2></div>
                <a href="{{ route('calendar.list') }}">Ver todas <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="home-event-grid">
                @forelse($upcomingEvents as $event)
                    <article class="home-event-card">
                        <div class="home-event-card__date" style="--event-color: {{ $event->category->color }}"><strong>{{ $event->starts_at->format('d') }}</strong><span>{{ $event->starts_at->locale('es')->translatedFormat('M') }}</span></div>
                        <div class="home-event-card__body">
                            <div class="home-event-card__meta"><span>{{ $event->category->name }}</span>@if($event->is_tentative)<span class="home-event-card__tentative">Fecha tentativa MEP</span>@endif</div>
                            <h3><a href="{{ route('calendar.show', $event) }}">{{ $event->title }}</a></h3>
                            <p><i class="far fa-clock" aria-hidden="true"></i> {{ $event->all_day ? 'Todo el día' : $event->starts_at->format('H:i') }} @if($event->location)<span><i class="fas fa-location-dot" aria-hidden="true"></i> {{ $event->location }}</span>@endif</p>
                        </div>
                    </article>
                @empty
                    <div class="home-empty-state"><i class="far fa-calendar-check" aria-hidden="true"></i><div><h3>No hay actividades próximas publicadas</h3><p>Consulte el calendario institucional para revisar otras fechas.</p></div></div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@if($page->script)
    @push('scripts')
        <script>{!! $page->script !!}</script>
    @endpush
@endif
