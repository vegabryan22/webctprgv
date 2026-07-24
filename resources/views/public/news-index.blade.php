@extends('layouts.public')
@section('title', 'Noticias - CTP Roberto Gamboa Valverde')
@section('content')
<main class="news-page">
    <header class="news-hero"><div><span>Actualidad institucional</span><h1>Noticias y comunicados</h1><p>Información oficial y novedades del CTP Roberto Gamboa Valverde.</p></div></header>
    <div class="news-shell">
        @if($categories->isNotEmpty())<nav class="news-filters" aria-label="Categorías de noticias"><a class="{{ request('category') ? '' : 'active' }}" href="{{ route('news') }}">Todas</a>@foreach($categories as $category)<a class="{{ request('category') === $category->slug ? 'active' : '' }}" href="{{ route('news', ['category' => $category->slug]) }}">{{ $category->name }}</a>@endforeach</nav>@endif
        <div class="news-grid">
            @forelse($articles as $article)
                <article class="news-card {{ $article->is_featured ? 'featured' : '' }}">
                    @if($article->image_path)<img src="{{ asset('storage/'.ltrim($article->image_path, '/')) }}" alt="">@else<div class="news-card__placeholder"><i class="fa-regular fa-newspaper" aria-hidden="true"></i></div>@endif
                    <div class="news-card__body"><div class="news-card__meta"><span style="--category-color: {{ $article->category->color }}">{{ $article->category->name }}</span><time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d M Y') }}</time></div><h2><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h2><p>{{ $article->summary }}</p><a class="news-card__link" href="{{ route('news.show', $article) }}">Leer noticia <i class="fas fa-arrow-right" aria-hidden="true"></i></a></div>
                </article>
            @empty
                <div class="news-empty"><i class="fa-regular fa-newspaper" aria-hidden="true"></i><h2>No hay noticias publicadas</h2><p>Las nuevas comunicaciones institucionales aparecerán en este espacio.</p><a href="{{ route('calendar.index') }}">Consultar calendario de actividades</a></div>
            @endforelse
        </div>
        {{ $articles->links('pagination.public') }}
    </div>
</main>
@endsection
