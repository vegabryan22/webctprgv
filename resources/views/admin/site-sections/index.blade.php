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
    <section class="maintenance-control {{ $maintenance->get('maintenance_enabled') === '1' ? 'active' : '' }}">
        <div class="maintenance-control__heading">
            <div class="maintenance-control__icon"><i class="fa-solid fa-person-digging"></i></div>
            <div><span>Acceso público</span><h2>Modo mantenimiento</h2><p>El público verá una pantalla temporal. Cualquier usuario autenticado podrá revisar el sitio completo; el rol Lector del sitio no permite entrar al panel.</p></div>
            <label class="maintenance-control__toggle">
                <input type="checkbox" name="maintenance_enabled" value="1" @checked($maintenance->get('maintenance_enabled') === '1')>
                <span aria-hidden="true"></span>
                <strong>Activar</strong>
            </label>
        </div>
        <div class="field-grid maintenance-control__fields">
            <div class="field"><label>Título público</label><input name="maintenance_title" value="{{ old('maintenance_title', $maintenance->get('maintenance_title')) }}" required maxlength="120"></div>
            <div class="field"><label>Mensaje público</label><textarea name="maintenance_message" required maxlength="500">{{ old('maintenance_message', $maintenance->get('maintenance_message')) }}</textarea></div>
        </div>
    </section>
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
