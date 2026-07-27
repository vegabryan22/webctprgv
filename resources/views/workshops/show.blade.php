@extends('layouts.public')
@section('title', $workshop->name . ' - CTP Roberto Gamboa Valverde')
@section('content')
<main class="service-page">
    <article class="service-detail workshop-detail">
        <a class="news-detail__back" href="{{ route('workshops') }}"><i class="fa-solid fa-arrow-left"></i> Volver a talleres</a>
        <header>
            <span>Taller exploratorio · {{ $workshop->grade_level }}</span>
            <h1>{{ $workshop->name }}</h1>
            <p>{{ $workshop->summary }}</p>
            @if($workshop->verified_at)<small><i class="fa-solid fa-circle-check"></i> Información verificada el {{ $workshop->verified_at->format('d/m/Y') }}</small>@endif
        </header>
        @if($workshop->image_path)<img class="news-detail__image" src="{{ asset('storage/'.ltrim($workshop->image_path, '/')) }}" alt="">@endif
        <div class="specialty-detail">
            @if($workshop->description)<section><h2>Descripción</h2><div>{!! $workshop->description !!}</div></section>@endif
            @if($workshop->curricularDocuments->isNotEmpty())<section><h2>Planes de estudio</h2><p>Consulte o descargue los programas oficiales disponibles.</p><x-curricular-documents :documents="$workshop->curricularDocuments" /></section>@endif
        </div>
    </article>
</main>
@endsection
