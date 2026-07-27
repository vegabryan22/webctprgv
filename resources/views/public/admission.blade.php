@extends('layouts.public')

@section('title', $page->title . ' - CTP Roberto Gamboa Valverde')

@section('content')
<main class="admission-page">
    <section class="admission-hero">
        <div class="admission-shell admission-hero__grid">
            <div>
                <span class="admission-eyebrow"><i class="fas fa-user-check"></i> Curso lectivo 2027</span>
                <h1>{{ $page->title }}</h1>
                <p>{{ $page->summary }}</p>
                <div class="admission-hero__actions">
                    <a class="admission-button admission-button--primary" href="#cronograma">Ver cronograma <i class="fas fa-arrow-down"></i></a>
                    <a class="admission-button" href="#documentos">Consultar documentos <i class="fas fa-file-pdf"></i></a>
                </div>
            </div>
            <aside class="admission-hero__notice">
                <i class="fas fa-circle-info"></i>
                <div>
                    <strong>Información respaldada por circulares institucionales</strong>
                    <p>Las fechas pueden cambiar mediante una comunicación posterior del CTPRGV. Revise siempre la circular correspondiente.</p>
                </div>
            </aside>
        </div>
    </section>

    <div class="admission-shell admission-content">
        <section class="admission-intro">
            {!! $page->content !!}
        </section>

        <section class="admission-pathways" aria-labelledby="admission-pathways-title">
            <header class="admission-section-heading">
                <span>Elija su recorrido</span>
                <h2 id="admission-pathways-title">¿A cuál proceso desea ingresar?</h2>
            </header>
            <div class="admission-pathways__grid">
                <article class="admission-pathway admission-pathway--seventh">
                    <div class="admission-pathway__icon"><i class="fas fa-school"></i></div>
                    <div>
                        <span class="admission-tag">Ingreso a secundaria</span>
                        <h3>Prematrícula para 7.º</h3>
                        <p>Dirigida exclusivamente a estudiantes que cursan 6.º durante 2026 y desean participar en el proceso de admisión para 2027.</p>
                        <ul>
                            <li>Cuenta con cronograma institucional publicado.</li>
                            <li>La entrega de documentos no garantiza el cupo.</li>
                            <li>La matrícula debe ratificarse después de la admisión.</li>
                        </ul>
                        <a href="#cronograma">Revisar fechas de 7.º <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="admission-pathway admission-pathway--tenth">
                    <div class="admission-pathway__icon"><i class="fas fa-screwdriver-wrench"></i></div>
                    <div>
                        <span class="admission-tag">Educación técnica</span>
                        <h3>Elección de especialidad para 10.º</h3>
                        <p>Proceso para estudiantes de 9.º que desean optar por una especialidad técnica. El cronograma específico se publicará cuando sea comunicado oficialmente.</p>
                        <ul>
                            <li>La oferta y los cupos dependen de la aprobación institucional vigente.</li>
                            <li>El reglamento completo está disponible para consulta.</li>
                            <li>Las especialidades pueden explorarse antes de elegir.</li>
                        </ul>
                        @if($siteSections->get('specialties', true))
                        <a href="{{ route('specialties') }}">Conocer especialidades <i class="fas fa-arrow-right"></i></a>
                        @endif
                    </div>
                </article>
            </div>
        </section>

        <section class="admission-schedule" id="cronograma" aria-labelledby="admission-schedule-title">
            <header class="admission-section-heading admission-section-heading--split">
                <div><span>Prematrícula de 7.º</span><h2 id="admission-schedule-title">Cronograma 2026 para ingreso en 2027</h2></div>
                @if($siteSections->get('calendar', true))
                <a href="{{ route('calendar.index', ['month' => '2026-07']) }}">Abrir calendario completo <i class="fas fa-arrow-right"></i></a>
                @endif
            </header>

            <ol class="admission-timeline">
                @foreach($events as $event)
                <li>
                    <div class="admission-timeline__date">
                        <strong>{{ $event->starts_at->format('d') }}</strong>
                        <span>{{ $event->starts_at->locale('es')->translatedFormat('M') }}</span>
                    </div>
                    <div class="admission-timeline__body">
                        <div class="admission-timeline__meta">
                            @if($event->ends_at && !$event->starts_at->isSameDay($event->ends_at))
                            <span><i class="far fa-calendar"></i> Hasta {{ $event->ends_at->translatedFormat('d \d\e F') }}</span>
                            @endif
                            <span><i class="far fa-clock"></i> {{ $event->all_day ? 'Periodo general' : $event->starts_at->format('H:i').($event->ends_at ? '–'.$event->ends_at->format('H:i') : '') }}</span>
                        </div>
                        <h3>
                            @if($siteSections->get('calendar', true))
                            <a href="{{ route('calendar.show', $event) }}">{{ $event->title }}</a>
                            @else
                            {{ $event->title }}
                            @endif
                        </h3>
                        <p>{{ $event->summary }}</p>
                    </div>
                </li>
                @endforeach
            </ol>
        </section>

        <section class="admission-documents" id="documentos" aria-labelledby="admission-documents-title">
            <header class="admission-section-heading admission-section-heading--split">
                <div><span>Fuentes oficiales</span><h2 id="admission-documents-title">Circulares y reglamento</h2></div>
                @if($siteSections->get('documents', true))
                <a href="{{ route('documents', ['category' => 'admision-matricula']) }}">Ver biblioteca documental <i class="fas fa-arrow-right"></i></a>
                @endif
            </header>

            <div class="admission-documents__notice">
                <i class="fas fa-shield-halved"></i>
                <p>Los archivos se ofrecen íntegros, sin modificar su contenido. Ante diferencias internas, consulte la comunicación más reciente emitida por Dirección.</p>
            </div>

            <div class="admission-documents__grid">
                @foreach($documents as $document)
                <article class="admission-document">
                    <div class="admission-document__icon"><i class="fas fa-file-pdf"></i></div>
                    <div>
                        <span>{{ $document->version }}</span>
                        <h3>{{ $document->title }}</h3>
                        <p>{{ $document->description }}</p>
                        <small><i class="far fa-calendar-check"></i> Emitido {{ $document->issued_at?->format('d/m/Y') }}</small>
                    </div>
                    <a href="{{ $document->publicUrl() }}" target="_blank" rel="noopener noreferrer" aria-label="Abrir {{ $document->title }}">
                        <i class="fas fa-arrow-up-right-from-square"></i>
                    </a>
                </article>
                @endforeach
            </div>
        </section>
    </div>
</main>
@endsection
