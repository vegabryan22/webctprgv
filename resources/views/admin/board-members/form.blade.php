@extends('layouts.admin')
@section('title', $member->exists ? 'Editar integrante' : 'Nuevo integrante')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-user-tie"></i> {{ $member->exists ? 'Editar integrante' : 'Nuevo integrante' }}</h1><a class="button ghost" href="{{ route('admin.board-members.index') }}">Volver</a></div>
<form class="card" method="POST" action="{{ $member->exists ? route('admin.board-members.update', $member) : route('admin.board-members.store') }}">@csrf @if($member->exists) @method('PUT') @endif
<div class="field-grid"><div class="field"><label>Nombre autorizado</label><input name="name" value="{{ old('name', $member->name) }}" required></div><div class="field"><label>Cargo</label><input name="position" value="{{ old('position', $member->position) }}" required></div></div>
<div class="field-grid"><div class="field"><label>Inicio del periodo</label><input type="date" name="term_starts_at" value="{{ old('term_starts_at', $member->term_starts_at?->format('Y-m-d')) }}"></div><div class="field"><label>Fin del periodo</label><input type="date" name="term_ends_at" value="{{ old('term_ends_at', $member->term_ends_at?->format('Y-m-d')) }}"></div></div>
<div class="field"><label>Fuente o acuerdo de respaldo</label><input name="source" value="{{ old('source', $member->source) }}" required><small class="muted">Indique acta, acuerdo, oficio u otra fuente institucional.</small></div>
<div class="field-grid"><div class="field"><label>Fecha de verificación</label><input type="date" name="verified_at" value="{{ old('verified_at', $member->verified_at?->format('Y-m-d')) }}"></div><div class="field"><label>Orden</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $member->sort_order ?? 0) }}"></div></div>
<div class="field"><label>Estado</label><select name="status"><option value="draft" @selected(old('status', $member->status ?: 'draft') === 'draft')>Borrador</option>@if(auth()->user()->hasPermission('board.publish'))<option value="published" @selected(old('status', $member->status) === 'published')>Publicado</option>@endif</select></div>
<button class="button secondary"><i class="fa-solid fa-floppy-disk"></i> Guardar integrante</button></form>
@endsection
