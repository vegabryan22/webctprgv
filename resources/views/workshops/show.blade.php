@extends('layouts.public')
@section('title', $workshop->name . ' - CTP Roberto Gamboa Valverde')
@section('content')
<main class="service-page">
    <article class="service-detail curricular-detail">
        <a class="news-detail__back curricular-detail__back" href="{{ route('workshops') }}">
            <i class="fa-solid fa-arrow-left"></i> Volver a talleres
        </a>

        <header class="curricular-detail__hero">
            <div class="curricular-detail__hero-copy">
                <span class="curricular-detail__eyebrow"><i class="fa-solid fa-compass-drafting"></i> Taller exploratorio</span>
                <h1>{{ $workshop->name }}</h1>
                <p>{{ $workshop->summary }}</p>
                <div class="curricular-detail__meta">
                    <span><i class="fa-solid fa-layer-group"></i> {{ $workshop->grade_level }}</span>
                    @if($workshop->verified_at)
                    <span><i class="fa-solid fa-circle-check"></i> Verificado el {{ $workshop->verified_at->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>
            <div class="curricular-detail__visual">
                @if($workshop->image_path)
                <img src="{{ asset('storage/'.ltrim($workshop->image_path, '/')) }}" alt="">
                @else
                <img class="curricular-illustration__image" src="{{ asset(\App\Support\CurricularIllustrations::path($workshop->slug)) }}" alt="">
                @endif
            </div>
        </header>

        <div class="curricular-detail__content">
            @if($workshop->description)
            <section class="curricular-detail__section curricular-detail__section--wide">
                <div class="curricular-detail__section-icon"><i class="fa-solid fa-lightbulb"></i></div>
                <div><h2>Descubre este taller</h2><div>{!! $workshop->description !!}</div></div>
            </section>
            @endif

            @if($workshop->curricularDocuments->isNotEmpty())
            <section class="curricular-detail__plans curricular-detail__section--wide">
                <div class="curricular-detail__plans-heading">
                    <div>
                        <span>Documento oficial</span>
                        <h2>Plan de estudio</h2>
                    </div>
                    <p>Ábrelo en línea o descarga el PDF.</p>
                </div>
                <x-curricular-documents :documents="$workshop->curricularDocuments" />
            </section>
            @endif
        </div>
    </article>
</main>
@endsection
