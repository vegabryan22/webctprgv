@extends('layouts.admin')
@section('title', $user->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-user-pen"></i> {{ $user->exists ? 'Editar usuario' : 'Nuevo usuario' }}</h1><a class="button ghost" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-arrow-left"></i> Volver</a></div>
<form class="card" method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">@csrf @if($user->exists) @method('PUT') @endif
<div class="field-grid"><div class="field"><label for="name">Nombre</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required></div><div class="field"><label for="email">Correo</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required></div></div>
<div class="field-grid"><div class="field"><label for="password">Contraseña {{ $user->exists ? '(dejar vacía para conservar)' : '' }}</label><input id="password" name="password" type="password" {{ $user->exists ? '' : 'required' }}></div><div class="field"><label for="password_confirmation">Confirmar contraseña</label><input id="password_confirmation" name="password_confirmation" type="password" {{ $user->exists ? '' : 'required' }}></div></div>
<div class="field"><label>Roles</label><div class="checks">@foreach($roles as $role)<label class="check"><input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked(in_array($role->id, old('roles', $user->roles->pluck('id')->all())))><span><strong>{{ $role->display_name }}</strong><br><small class="muted">{{ $role->description }}</small></span></label>@endforeach</div></div>
<button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar usuario</button></form>
@endsection
