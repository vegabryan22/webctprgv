@extends('layouts.admin')
@section('title', 'Resumen')
@section('content')
<div class="page-heading"><div><h1>Resumen del sitio</h1><p class="muted">Estado general del contenido y la administración.</p></div><span class="badge">Versión {{ config('version.number') }}</span></div>
<section class="metrics">@foreach($metrics as $label => $value)<article class="card metric"><strong>{{ $value }}</strong><span>{{ $label }}</span></article>@endforeach</section>
@endsection
