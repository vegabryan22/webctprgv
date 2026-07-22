@extends('layouts.admin')
@section('title', 'Configuración')
@section('content')
<div class="page-heading"><div><h1>Configuración del sitio</h1><p class="muted">Datos institucionales reutilizables en el contenido.</p></div></div>
<form class="card" method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
@forelse($settings as $group => $items)<h2>{{ ucfirst($group) }}</h2><div class="field-grid">@foreach($items as $setting)<div class="field"><label for="setting_{{ $setting->id }}">{{ $setting->label }}</label><input id="setting_{{ $setting->id }}" type="{{ $setting->type }}" name="settings[{{ $setting->key }}]" value="{{ old('settings.'.$setting->key, $setting->value) }}"></div>@endforeach</div>@empty<p>No hay opciones configuradas.</p>@endforelse
<button class="button secondary" type="submit">Guardar configuración</button></form>
@endsection
