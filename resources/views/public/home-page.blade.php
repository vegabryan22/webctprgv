@extends('layouts.public')

@section('title', $page->title)

@section('content')
<main class="modern-home">
    <section class="modern-home__hero">
        <div class="modern-home__hero-overlay"></div>
        <div class="modern-home__hero-content">
            <span class="modern-home__eyebrow">Educación pública técnica</span>
            <h1>CTP Roberto Gamboa Valverde</h1>
            <p>Formación académica y técnica para construir el futuro de nuestra comunidad estudiantil.</p>
            <div class="modern-home__hero-actions">
                @if($siteSections->get('specialties', true))
                <a class="modern-home__button modern-home__button--primary" href="{{ route('specialties') }}">Explorar oferta técnica <i class="fas fa-arrow-right"></i></a>
                @endif
                @if($siteSections->get('institution', true))
                <a class="modern-home__button modern-home__button--secondary" href="{{ route('information') }}">Conocer la institución</a>
                @endif
            </div>
        </div>
        <a class="modern-home__scroll" href="#accesos" aria-label="Continuar a los accesos rápidos"><i class="fas fa-chevron-down"></i></a>
    </section>

    <section class="modern-home__quick" id="accesos" aria-labelledby="quick-title">
        <div class="modern-home__shell">
            <header class="modern-home__section-heading">
                <div><span class="modern-home__eyebrow">Accesos rápidos</span><h2 id="quick-title">¿Qué necesita consultar?</h2></div>
            </header>
            <nav class="modern-home__quick-grid" aria-label="Accesos rápidos">
                @if($siteSections->get('admission', true))
                <a href="{{ route('admission') }}"><i class="fas fa-user-check"></i><span><strong>Admisión 2027</strong><small>Prematrícula y procesos de ingreso</small></span><i class="fas fa-arrow-right"></i></a>
                @endif
                @if($siteSections->get('calendar', true))
                <a href="{{ route('calendar.index') }}"><i class="fas fa-calendar-days"></i><span><strong>Calendario</strong><small>Fechas y actividades</small></span><i class="fas fa-arrow-right"></i></a>
                @endif
                @if($siteSections->get('services', true))
                <a href="{{ route('services.index') }}"><i class="fas fa-hand-holding-heart"></i><span><strong>Servicios</strong><small>Atención institucional</small></span><i class="fas fa-arrow-right"></i></a>
                @endif
                @if($siteSections->get('institution', true))
                <a href="{{ route('information') }}"><i class="fas fa-school"></i><span><strong>Institución</strong><small>Identidad y trayectoria</small></span><i class="fas fa-arrow-right"></i></a>
                @endif
                @if($siteSections->get('contact', true))
                <a href="{{ route('contact') }}"><i class="fas fa-address-book"></i><span><strong>Contacto</strong><small>Ubicación y atención</small></span><i class="fas fa-arrow-right"></i></a>
                @endif
            </nav>
        </div>
    </section>

    @if($siteSections->get('workshops', true) || $siteSections->get('specialties', true))
    <section class="modern-home__academic" aria-labelledby="academic-title">
        <div class="modern-home__shell">
            <header class="modern-home__section-heading modern-home__section-heading--center">
                <div><span class="modern-home__eyebrow">Formación técnica</span><h2 id="academic-title">Encuentre su recorrido educativo</h2><p>Explore talleres antes de elegir una especialidad y conozca los planes de estudio disponibles.</p></div>
            </header>
            <div class="modern-home__pathways">
                @if($siteSections->get('workshops', true))
                <article class="modern-home__pathway">
                    <img src="{{ asset('images/curricular/items/construye-y-programa-tus-propios-dispositivos-electronicos-iot.jpg') }}" alt="">
                    <div>
                        <span>7.º, 8.º y 9.º</span>
                        <h3>Talleres exploratorios</h3>
                        <p>{{ $workshopCount }} experiencias para descubrir intereses, habilidades y áreas técnicas.</p>
                        <a href="{{ route('workshops') }}">Conocer talleres <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                @endif
                @if($siteSections->get('specialties', true))
                <article class="modern-home__pathway">
                    <img src="{{ asset('images/curricular/items/dibujo-y-modelado-de-edificaciones.jpg') }}" alt="">
                    <div>
                        <span>10.º, 11.º y 12.º</span>
                        <h3>Especialidades técnicas</h3>
                        <p>{{ $specialtyCount }} opciones de formación técnica con información y programas por nivel.</p>
                        <a href="{{ route('specialties') }}">Ver especialidades <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                @endif
            </div>
        </div>
    </section>
    @endif

    @if($siteSections->get('calendar', true))
    <section class="modern-home__agenda" aria-labelledby="agenda-title">
        <div class="modern-home__shell">
            <header class="modern-home__section-heading">
                <div><span class="modern-home__eyebrow">Agenda institucional</span><h2 id="agenda-title">Próximas actividades</h2></div>
                <a href="{{ route('calendar.list') }}">Ver calendario completo <i class="fas fa-arrow-right"></i></a>
            </header>
            <div class="modern-home__event-grid">
                @forelse($upcomingEvents as $event)
                <article class="modern-home__event">
                    <div class="modern-home__event-date" style="--event-color: {{ $event->category->color }}"><strong>{{ $event->starts_at->format('d') }}</strong><span>{{ $event->starts_at->locale('es')->translatedFormat('M') }}</span></div>
                    <div>
                        <span class="modern-home__event-category">{{ $event->category->name }}</span>
                        <h3><a href="{{ route('calendar.show', $event) }}">{{ $event->title }}</a></h3>
                        <p><i class="far fa-clock"></i> {{ $event->all_day ? 'Todo el día' : $event->starts_at->format('H:i') }}</p>
                    </div>
                </article>
                @empty
                <div class="modern-home__empty"><i class="far fa-calendar-check"></i><div><h3>No hay actividades próximas publicadas</h3><p>Consulte el calendario institucional para revisar otras fechas.</p></div></div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if($siteSections->get('news', true) && $latestNews->isNotEmpty())
    <section class="modern-home__news" aria-labelledby="news-title">
        <div class="modern-home__shell">
            <header class="modern-home__section-heading">
                <div><span class="modern-home__eyebrow">Actualidad</span><h2 id="news-title">Noticias recientes</h2></div>
                <a href="{{ route('news') }}">Ver todas <i class="fas fa-arrow-right"></i></a>
            </header>
            <div class="modern-home__news-grid">
                @foreach($latestNews as $article)
                <article class="modern-home__news-card">
                    @if($article->image_path)<img src="{{ asset('storage/'.ltrim($article->image_path, '/')) }}" alt="">@else<div><i class="fas fa-newspaper"></i></div>@endif
                    <section><span>{{ $article->category?->name }} · {{ $article->published_at->format('d/m/Y') }}</span><h3><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h3><p>{{ $article->summary }}</p></section>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($siteSections->get('institution', true))
    <section class="modern-home__identity">
        <div class="modern-home__shell">
            <div><span class="modern-home__eyebrow">Nuestra institución</span><h2>Conozca quiénes somos</h2><p>Consulte la información institucional, misión, visión y otros contenidos de referencia del colegio.</p></div>
            <a class="modern-home__button modern-home__button--primary" href="{{ route('information') }}">Conocer la institución <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>
    @endif
</main>
@endsection
