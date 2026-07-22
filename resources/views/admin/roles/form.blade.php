@extends('layouts.admin')
@section('title', $role->exists ? 'Editar rol' : 'Nuevo rol')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-shield"></i> {{ $role->exists ? 'Editar rol' : 'Nuevo rol' }}</h1><a class="button ghost" href="{{ route('admin.roles.index') }}"><i class="fa-solid fa-arrow-left"></i> Volver</a></div>
<form class="card" method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">@csrf @if($role->exists) @method('PUT') @endif
<div class="field-grid"><div class="field"><label for="display_name">Nombre visible</label><input id="display_name" name="display_name" value="{{ old('display_name', $role->display_name) }}" required></div><div class="field"><label for="name">Identificador</label><input id="name" name="name" value="{{ old('name', $role->name) }}" required><small class="muted">Ejemplo: editor-noticias</small></div></div>
<div class="field"><label for="description">Descripción</label><textarea id="description" name="description">{{ old('description', $role->description) }}</textarea></div>
<div class="field"><label>Permisos</label>@foreach($permissions as $group => $items)<h3>{{ $group }}</h3><div class="checks">@foreach($items as $permission)<label class="check"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', $role->permissions->pluck('id')->all())))><span><strong>{{ $permission->display_name }}</strong><br><small class="muted"><code>{{ $permission->name }}</code></small></span></label>@endforeach</div>@endforeach</div>
<button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar rol</button></form>
@endsection
