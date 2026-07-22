@extends('layouts.public')

@section('title', $page->title . ' - CTP Roberto Gamboa Valverde')

@section('content')
    <header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>{{ $page->title }}</h1>
            @if ($page->summary)<p>{{ $page->summary }}</p>@endif
        </div>
    </header>
    <main class="intro-section">
        <div class="container">{!! nl2br(e($page->content)) !!}</div>
    </main>
@endsection
