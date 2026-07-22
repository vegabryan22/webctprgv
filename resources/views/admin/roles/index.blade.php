@extends('layouts.admin')
@section('title', 'Roles y permisos')
@section('content')
<div class="page-heading"><div><h1><i class="fa-solid fa-shield-halved"></i> Roles y permisos</h1><p class="muted">Defina responsabilidades sin otorgar acceso innecesario.</p></div>@if(auth()->user()->hasPermission('roles.manage'))<a class="button" href="{{ route('admin.roles.create') }}"><i class="fa-solid fa-plus"></i> Nuevo rol</a>@endif</div>
<div class="card table-wrap"><table><thead><tr><th>Rol</th><th>Identificador</th><th>Usuarios</th><th>Tipo</th><th>Acciones</th></tr></thead><tbody>
@foreach($roles as $role)<tr><td><strong>{{ $role->display_name }}</strong><br><small class="muted">{{ $role->description }}</small></td><td><code>{{ $role->name }}</code></td><td>{{ $role->users_count }}</td><td>{{ $role->is_system ? 'Sistema' : 'Personalizado' }}</td><td>@if(auth()->user()->hasPermission('roles.manage') && !$role->is_system)<div class="actions"><a class="button link" href="{{ route('admin.roles.edit', $role) }}"><i class="fa-solid fa-pen"></i> Editar</a><form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('¿Eliminar este rol?')">@csrf @method('DELETE')<button class="button link" type="submit"><i class="fa-regular fa-trash-can"></i> Eliminar</button></form></div>@else<span class="badge neutral"><i class="fa-solid fa-lock"></i> Protegido</span>@endif</td></tr>@endforeach
</tbody></table></div>
@endsection
