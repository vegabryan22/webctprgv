@extends('layouts.admin')

@section('title', 'Contacto')

@section('content')
<div class="page-heading">
    <div>
        <h1><i class="fa-solid fa-address-card"></i> Contacto público</h1>
        <p class="muted">Administre los datos que aparecen en la página pública de contacto.</p>
    </div>
    <a class="button ghost" href="{{ route('contact') }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver página</a>
</div>

<form class="card" method="POST" action="{{ route('admin.contact.update') }}">
    @csrf
    @method('PUT')

    <h2>Presentación</h2>
    <div class="field">
        <label for="contact_heading">Título</label>
        <input id="contact_heading" name="contact_heading" value="{{ old('contact_heading', $settings['contact_heading'] ?? '') }}" required>
    </div>
    <div class="field">
        <label for="contact_intro">Texto introductorio</label>
        <textarea id="contact_intro" name="contact_intro" rows="3">{{ old('contact_intro', $settings['contact_intro'] ?? '') }}</textarea>
    </div>

    <h2>Canales de atención</h2>
    <div class="field-grid">
        <div class="field">
            <label for="contact_phone">Teléfono principal</label>
            <input id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
        </div>
        <div class="field">
            <label for="contact_phone_secondary">Teléfono secundario</label>
            <input id="contact_phone_secondary" name="contact_phone_secondary" value="{{ old('contact_phone_secondary', $settings['contact_phone_secondary'] ?? '') }}">
        </div>
        <div class="field">
            <label for="contact_email">Correo electrónico</label>
            <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
        </div>
        <div class="field">
            <label for="contact_hours">Horario de atención</label>
            <input id="contact_hours" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours'] ?? '') }}">
        </div>
    </div>

    <h2>Ubicación</h2>
    <div class="field">
        <label for="contact_address">Dirección</label>
        <textarea id="contact_address" name="contact_address" rows="3">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
    </div>
    <div class="field">
        <label for="contact_map_url">Enlace público del mapa</label>
        <input id="contact_map_url" type="url" name="contact_map_url" value="{{ old('contact_map_url', $settings['contact_map_url'] ?? '') }}" placeholder="https://maps.google.com/...">
        <small class="muted">Use un enlace para abrir la ubicación; no pegue código HTML ni iframes.</small>
    </div>

    <h2>Verificación</h2>
    <div class="field-grid">
        <div class="field">
            <label for="contact_verified_at">Fecha de verificación</label>
            <input id="contact_verified_at" type="date" name="contact_verified_at" value="{{ old('contact_verified_at', $settings['contact_verified_at'] ?? '') }}">
        </div>
        <div class="field">
            <label for="contact_source">Fuente o responsable</label>
            <input id="contact_source" name="contact_source" value="{{ old('contact_source', $settings['contact_source'] ?? '') }}">
        </div>
    </div>

    <div class="actions">
        <button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar contacto</button>
    </div>
</form>
@endsection
