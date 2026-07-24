@extends('layouts.public')
@section('title', $article->title . ' - CTP Roberto Gamboa Valverde')
@section('content')
<main class="news-page"><article class="news-detail">
    <a class="news-detail__back" href="{{ route('news') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i> Volver a noticias</a>
    <header><span class="news-detail__category" style="--category-color: {{ $article->category->color }}">{{ $article->category->name }}</span><h1>{{ $article->title }}</h1><div class="news-detail__meta"><time datetime="{{ $article->published_at->toDateString() }}"><i class="far fa-calendar" aria-hidden="true"></i> {{ $article->published_at->translatedFormat('d \d\e F \d\e Y') }}</time>@if($article->author)<span><i class="far fa-user" aria-hidden="true"></i> {{ $article->author->name }}</span>@endif</div><p class="news-detail__summary">{{ $article->summary }}</p></header>
    @if($article->image_path)<img class="news-detail__image" src="{{ Storage::url($article->image_path) }}" alt="">@endif
    <div class="news-detail__content">{!! $article->content !!}</div>
    @if($article->attachment_path)<a class="news-download" href="{{ Storage::url($article->attachment_path) }}" target="_blank"><i class="fas fa-file-arrow-down" aria-hidden="true"></i> Descargar documento adjunto</a>@endif
</article></main>
@endsection
