@extends('layouts.admin')
@section('title', 'Resumen')
@section('content')
<div class="page-heading"><div><h1><i class="fa-solid fa-chart-line"></i> Resumen del sitio</h1><p class="muted">Estado general del contenido y la administración.</p></div><span class="badge"><i class="fa-solid fa-code-branch"></i> Versión {{ config('version.number') }}</span></div>
@php($metricIcons = ['Usuarios' => 'fa-users', 'Roles' => 'fa-shield-halved', 'Páginas' => 'fa-file-lines', 'Publicadas' => 'fa-circle-check'])
<section class="metrics">@foreach($metrics as $label => $value)<article class="card metric"><i class="fa-solid {{ $metricIcons[$label] ?? 'fa-chart-simple' }} muted"></i><strong>{{ $value }}</strong><span>{{ $label }}</span></article>@endforeach</section>
@endsection
