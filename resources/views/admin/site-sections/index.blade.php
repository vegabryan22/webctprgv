@extends('layouts.admin')

@section('title', 'Estado del sitio')

@section('content')
<div class="page-heading">
    <div><h1><i class="fa-solid fa-toggle-on"></i> Estado del sitio</h1><p class="muted">Active o desactive rápidamente las secciones públicas. Inicio y Administración permanecen disponibles.</p></div>
    <a class="button ghost" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver sitio</a>
</div>

<form method="POST" action="{{ route('admin.site-sections.update') }}">
    @csrf
    @method('PUT')
    <div class="section-status-grid">
        @foreach($sections as $section)
            <label class="section-status-card">
                <input type="checkbox" name="active[]" value="{{ $section->key }}" @checked($section->is_active)>
                <span class="section-status-card__switch" aria-hidden="true"></span>
                <span><strong>{{ $section->label }}</strong><small>{{ $section->description }}</small><em>{{ $section->is_active ? 'Visible' : 'Desactivada' }}</em></span>
            </label>
        @endforeach
    </div>
    <div class="actions section-status-actions"><button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar estado del sitio</button></div>
</form>
@endsection
