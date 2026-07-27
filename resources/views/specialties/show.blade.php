@extends('layouts.public')
@section('title', $specialty->name . ' - CTP Roberto Gamboa Valverde')
@section('content')
<main class="service-page">
    <article class="service-detail curricular-detail">
        <a class="news-detail__back curricular-detail__back" href="{{ route('specialties') }}">
            <i class="fa-solid fa-arrow-left"></i> Volver a especialidades
        </a>

        <header class="curricular-detail__hero">
            <div class="curricular-detail__hero-copy">
                <span class="curricular-detail__eyebrow"><i class="fa-solid fa-graduation-cap"></i> Especialidad técnica</span>
                <h1>{{ $specialty->name }}</h1>
                <p>{{ $specialty->summary }}</p>
                <div class="curricular-detail__meta">
                    <span><i class="fa-solid fa-layer-group"></i> {{ $specialty->grade_levels }}</span>
                    @if($specialty->verified_at)
                    <span><i class="fa-solid fa-circle-check"></i> Verificado el {{ $specialty->verified_at->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>
            <div class="curricular-detail__visual @if(!$specialty->image_path) curricular-illustration @endif" @if(!$specialty->image_path) style="background-image: url('{{ asset(\App\Support\CurricularIllustrations::path($specialty->slug)) }}')" @endif>
                @if($specialty->image_path)
                <img src="{{ asset('storage/'.ltrim($specialty->image_path, '/')) }}" alt="">
                @endif
            </div>
        </header>

        <div class="curricular-detail__content">
            @if($specialty->description)
            <section class="curricular-detail__section curricular-detail__section--wide">
                <div class="curricular-detail__section-icon"><i class="fa-solid fa-circle-info"></i></div>
                <div><h2>¿En qué consiste?</h2><div>{!! $specialty->description !!}</div></div>
            </section>
            @endif

            @if($specialty->student_profile)
            <section class="curricular-detail__section">
                <div class="curricular-detail__section-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div><h2>Perfil del estudiante</h2><div>{!! $specialty->student_profile !!}</div></div>
            </section>
            @endif

            @if($specialty->curriculum)
            <section class="curricular-detail__section">
                <div class="curricular-detail__section-icon"><i class="fa-solid fa-list-check"></i></div>
                <div><h2>Lo que aprenderás</h2><div>{!! $specialty->curriculum !!}</div></div>
            </section>
            @endif

            @if($specialty->career_opportunities)
            <section class="curricular-detail__section curricular-detail__section--wide">
                <div class="curricular-detail__section-icon"><i class="fa-solid fa-briefcase"></i></div>
                <div><h2>Oportunidades profesionales</h2><div>{!! $specialty->career_opportunities !!}</div></div>
            </section>
            @endif

            @if($specialty->curricularDocuments->isNotEmpty())
            <section class="curricular-detail__plans curricular-detail__section--wide">
                <div class="curricular-detail__plans-heading">
                    <div>
                        <span>Documentos oficiales</span>
                        <h2>Planes de estudio por nivel</h2>
                    </div>
                    <p>Ábrelos en línea o descarga el PDF.</p>
                </div>
                <x-curricular-documents :documents="$specialty->curricularDocuments" />
            </section>
            @endif

            @if($specialty->coordinator || $specialty->contact_email || $specialty->official_program_url)
            <aside class="curricular-detail__official curricular-detail__section--wide">
                <h2><i class="fa-solid fa-building-columns"></i> Información oficial</h2>
                @if($specialty->coordinator)<p><strong>Coordinación</strong>{{ $specialty->coordinator }}</p>@endif
                @if($specialty->contact_email)<p><strong>Correo</strong><a href="mailto:{{ $specialty->contact_email }}">{{ $specialty->contact_email }}</a></p>@endif
                @if($specialty->official_program_url)<a class="news-download" href="{{ $specialty->official_program_url }}" target="_blank" rel="noopener">Consultar programa oficial</a>@endif
            </aside>
            @endif
        </div>
    </article>
</main>
@endsection
