@extends('layouts.admin')
@section('title', 'Usuarios')
@section('content')
<div class="page-heading"><div><h1>Usuarios</h1><p class="muted">Cuentas con acceso al CMS.</p></div>@if(auth()->user()->hasPermission('users.create'))<a class="button" href="{{ route('admin.users.create') }}">Nuevo usuario</a>@endif</div>
<div class="card table-wrap"><table><thead><tr><th>Nombre</th><th>Correo</th><th>Roles</th><th>Acciones</th></tr></thead><tbody>
@forelse($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>@forelse($user->roles as $role)<span class="badge">{{ $role->display_name }}</span>@empty<span class="muted">Sin rol</span>@endforelse</td><td><div class="actions">@if(auth()->user()->hasPermission('users.update'))<a class="button link" href="{{ route('admin.users.edit', $user) }}">Editar</a>@endif @if(auth()->user()->hasPermission('users.delete') && !auth()->user()->is($user))<form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Eliminar este usuario?')">@csrf @method('DELETE')<button class="button link" type="submit">Eliminar</button></form>@endif</div></td></tr>@empty<tr><td colspan="4">No hay usuarios.</td></tr>@endforelse
</tbody></table>{{ $users->links() }}</div>
@endsection
