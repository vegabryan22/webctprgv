@extends('layouts.admin')
@section('title', 'Revisión editorial')
@section('content')
<div class="page-heading">
    <div><h1><i class="fa-solid fa-magnifying-glass-chart"></i> Revisión editorial</h1><p class="muted">Señales automáticas que requieren revisión humana antes de considerar oficial el contenido.</p></div>
    <a class="button ghost" href="{{ route('admin.pages.index') }}"><i class="fa-regular fa-file-lines"></i> Administrar páginas</a>
</div>
<div class="metrics">
    <article class="metric"><span>Hallazgos</span><strong>{{ $totalFindings }}</strong><i class="fa-solid fa-list-check"></i></article>
    <article class="metric"><span>Prioridad alta</span><strong>{{ $highFindings }}</strong><i class="fa-solid fa-triangle-exclamation"></i></article>
    <article class="metric"><span>Páginas revisadas</span><strong>{{ $pages->count() }}</strong><i class="fa-regular fa-file-lines"></i></article>
</div>
<div class="audit-list">
@foreach($pages as $result)
    <section class="card audit-page">
        <header class="audit-page__header">
            <div><h2>{{ $result['page']->title }}</h2><p class="muted">{{ $result['page']->route_name ? route($result['page']->route_name, absolute: false) : '/paginas/'.$result['page']->slug }}</p></div>
            <div class="actions"><span class="badge {{ $result['score'] >= 85 ? 'success' : ($result['score'] >= 60 ? 'warning' : 'danger') }}">{{ $result['score'] }}/100</span>@if(auth()->user()->hasPermission('pages.manage'))<a class="button link" href="{{ route('admin.pages.edit', $result['page']) }}"><i class="fa-solid fa-pen"></i> Revisar página</a>@endif</div>
        </header>
        @if($result['findings']->isEmpty())
            <p class="audit-ok"><i class="fa-solid fa-circle-check"></i> No se detectaron señales automáticas. Esto no sustituye la validación institucional.</p>
        @else
            <div class="audit-findings">@foreach($result['findings'] as $finding)<article class="audit-finding {{ $finding['severity'] }}"><i class="fa-solid {{ $finding['severity'] === 'high' ? 'fa-circle-exclamation' : ($finding['severity'] === 'medium' ? 'fa-triangle-exclamation' : 'fa-circle-info') }}"></i><div><strong>{{ $finding['title'] }}</strong><p>{{ $finding['description'] }}</p></div></article>@endforeach</div>
        @endif
    </section>
@endforeach
</div>
@endsection
