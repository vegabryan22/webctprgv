@extends('layouts.admin')
@section('title', $page->exists ? 'Editar página' : 'Nueva página')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-file-pen"></i> {{ $page->exists ? 'Editar página' : 'Nueva página' }}</h1><a class="button ghost" href="{{ route('admin.pages.index') }}"><i class="fa-solid fa-arrow-left"></i> Volver</a></div>
<form class="card" method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}">@csrf @if($page->exists) @method('PUT') @endif
<div class="field-grid"><div class="field"><label for="title">Título</label><input id="title" name="title" value="{{ old('title', $page->title) }}" required></div><div class="field"><label for="slug">Dirección amigable</label><input id="slug" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="ejemplo-de-pagina" required></div></div>
<div class="field"><label for="summary">Resumen</label><textarea id="summary" name="summary">{{ old('summary', $page->summary) }}</textarea></div>
<div class="field"><label for="content">Contenido</label><textarea id="content" name="content" rows="16">{{ old('content', $page->content) }}</textarea><small class="muted">El contenido se publica como texto seguro; los saltos de línea se conservan.</small></div>
<div class="field"><label for="status">Estado</label><select id="status" name="status"><option value="draft" @selected(old('status', $page->status ?: 'draft') === 'draft')>Borrador</option>@if(auth()->user()->hasPermission('pages.publish'))<option value="published" @selected(old('status', $page->status) === 'published')>Publicada</option>@endif<option value="archived" @selected(old('status', $page->status) === 'archived')>Archivada</option></select></div>
<button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar página</button></form>
@endsection
