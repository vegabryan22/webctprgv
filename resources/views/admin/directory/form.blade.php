@extends('layouts.admin')
@section('title', $entry->exists ? 'Editar contacto' : 'Nuevo contacto')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-address-card"></i> {{ $entry->exists ? 'Editar contacto' : 'Nuevo contacto' }}</h1><a class="button ghost" href="{{ route('admin.directory.index') }}">Volver</a></div>
<form class="card" method="POST" action="{{ $entry->exists ? route('admin.directory.update', $entry) : route('admin.directory.store') }}">@csrf @if($entry->exists) @method('PUT') @endif
<div class="field-grid"><div class="field"><label>Departamento</label><input name="department" value="{{ old('department',$entry->department) }}" required></div><div class="field"><label>Cargo o función</label><input name="position" value="{{ old('position',$entry->position) }}"></div></div>
<div class="field"><label>Nombre de la persona (opcional)</label><input name="person_name" value="{{ old('person_name',$entry->person_name) }}"><small class="muted">Use únicamente nombres autorizados. Prefiera el contacto departamental.</small></div>
<div class="field-grid"><div class="field"><label>Teléfono institucional</label><input name="phone" value="{{ old('phone',$entry->phone) }}"></div><div class="field"><label>Extensión</label><input name="extension" value="{{ old('extension',$entry->extension) }}"></div></div>
<div class="field-grid"><div class="field"><label>Correo institucional</label><input name="email" type="email" value="{{ old('email',$entry->email) }}"></div><div class="field"><label>Horario</label><input name="schedule" value="{{ old('schedule',$entry->schedule) }}"></div></div>
<div class="field"><label>Notas públicas</label><textarea name="notes" rows="3">{{ old('notes',$entry->notes) }}</textarea></div>
<div class="field-grid"><div class="field"><label>Fecha de verificación</label><input name="verified_at" type="date" value="{{ old('verified_at',$entry->verified_at?->format('Y-m-d')) }}"></div><div class="field"><label>Orden</label><input name="sort_order" type="number" min="0" value="{{ old('sort_order',$entry->sort_order ?? 0) }}"></div></div>
<div class="field"><label>Estado</label><select name="status"><option value="draft" @selected(old('status',$entry->status ?: 'draft')==='draft')>Borrador</option>@if(auth()->user()->hasPermission('directory.publish'))<option value="published" @selected(old('status',$entry->status)==='published')>Publicado</option>@endif</select></div>
<button class="button secondary"><i class="fa-solid fa-floppy-disk"></i> Guardar contacto</button></form>
@endsection
