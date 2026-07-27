@extends('layouts.public')

@section('title', 'Junta Administrativa y transparencia - CTP Roberto Gamboa Valverde')

@section('content')
@php
    $categories = [
        'uniform' => ['Uniformes', 'fa-shirt'],
        'material' => ['Materiales', 'fa-book'],
        'procurement' => ['Licitaciones y contrataciones', 'fa-file-signature'],
        'project' => ['Proyectos', 'fa-diagram-project'],
        'report' => ['Informes', 'fa-chart-column'],
        'notice' => ['Avisos', 'fa-bullhorn'],
    ];
@endphp
<main class="board-page">
    <header class="service-hero board-hero"><div><span>Gobernanza institucional</span><h1>Junta Administrativa</h1><p>{{ $page?->summary ?: 'Información institucional verificada sobre servicios, proyectos, contrataciones e informes.' }}</p></div></header>

    <div class="service-shell board-shell">
        @if($page?->content)<section class="board-introduction">{!! $page->content !!}</section>@endif

        <section class="board-publications">
            <div class="section-heading"><div><span>Información actualizada</span><h2>Publicaciones y servicios</h2><p>Solo se muestran datos respaldados y vigentes.</p></div></div>
            @forelse($categories as $type => [$label, $icon])
                @if($records->get($type, collect())->isNotEmpty())
                    <section class="board-category">
                        <header><i class="fa-solid {{ $icon }}"></i><div><span>{{ $records->get($type)->count() }} {{ $records->get($type)->count() === 1 ? 'publicación' : 'publicaciones' }}</span><h3>{{ $label }}</h3></div></header>
                        <div class="board-publication-grid">
                            @foreach($records->get($type) as $record)
                                <article class="board-publication-card">
                                    <div class="board-publication-card__top"><span>{{ $record->typeLabel() }}</span>@if($record->record_date)<time datetime="{{ $record->record_date->toDateString() }}">{{ $record->record_date->format('d/m/Y') }}</time>@endif</div>
                                    <h4>{{ $record->title }}</h4>
                                    @if($record->summary)<p>{{ $record->summary }}</p>@endif
                                    @if($record->content)<div class="transparency-content">{!! $record->content !!}</div>@endif
                                    @if(in_array($record->type, ['uniform', 'material'], true))
                                        <div class="board-price">
                                            @if($record->price !== null)<strong>₡{{ number_format((float) $record->price, 2, ',', '.') }}</strong>
                                            @else<span>{{ $record->price_note ?: 'Precio pendiente de confirmación' }}</span>@endif
                                        </div>
                                    @elseif($record->price !== null || $record->price_note)
                                        <div class="board-price">@if($record->price !== null)<strong>₡{{ number_format((float) $record->price, 2, ',', '.') }}</strong>@endif @if($record->price_note)<span>{{ $record->price_note }}</span>@endif</div>
                                    @endif
                                    @if($record->valid_until)<p class="board-validity"><i class="fa-regular fa-calendar-check"></i> Vigente hasta {{ $record->valid_until->format('d/m/Y') }}</p>@endif
                                    <small>Responsable: {{ $record->responsible }}<br>Fuente: {{ $record->source }} · Verificado: {{ $record->verified_at->format('d/m/Y') }}</small>
                                    @if($record->documents->isNotEmpty())<div class="transparency-documents">@foreach($record->documents as $document)<a href="{{ asset('storage/'.ltrim($document->file_path, '/')) }}" target="_blank" rel="noopener"><i class="fa-regular fa-file-lines"></i> {{ $document->title }}</a>@endforeach</div>@endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @empty
                <div class="news-empty"><i class="fa-solid fa-scale-balanced"></i><h2>Publicaciones pendientes</h2><p>La información aparecerá cuando sea verificada por la Junta Administrativa.</p></div>
            @endforelse
        </section>

        <section class="board-members">
            <div class="section-heading"><div><span>Integración vigente</span><h2>Miembros de la Junta Administrativa</h2></div></div>
            <div class="board-member-grid">@forelse($members as $member)<article class="board-member-card"><i class="fa-solid fa-user-tie"></i><div><h3>{{ $member->name }}</h3><p>{{ $member->position }}</p><small>@if($member->term_starts_at || $member->term_ends_at)Periodo: {{ $member->term_starts_at?->format('d/m/Y') ?: 'sin fecha inicial' }} — {{ $member->term_ends_at?->format('d/m/Y') ?: 'vigente' }}<br>@endif Verificado: {{ $member->verified_at->format('d/m/Y') }} · Fuente: {{ $member->source }}</small></div></article>@empty<div class="news-empty"><i class="fa-solid fa-people-group"></i><h2>Integración pendiente de verificación</h2><p>Los nombres y cargos se publicarán cuando exista respaldo institucional vigente.</p></div>@endforelse</div>
        </section>
    </div>
</main>
@endsection
