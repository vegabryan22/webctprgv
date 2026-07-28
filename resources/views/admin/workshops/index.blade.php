@extends('layouts.admin')
@section('title', 'Talleres exploratorios')
@section('content')
<div class="page-heading">
    <div>
        <h1><i class="fa-solid fa-compass-drafting"></i> Talleres exploratorios</h1>
        <p class="muted">La publicación controla la aprobación editorial; la visibilidad permite retirar temporalmente un taller ya publicado.</p>
    </div>
    <div class="actions">
        <a class="button ghost" href="{{ route('workshops') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Ver oferta</a>
        @if(auth()->user()->hasPermission('workshops.manage'))
        <a class="button" href="{{ route('admin.workshops.create') }}"><i class="fa-solid fa-plus"></i> Nuevo taller</a>
        @endif
    </div>
</div>

<div class="card table-wrap curricular-admin-table">
    <table>
        <thead><tr><th>Taller</th><th>Nivel</th><th>Verificación</th><th>Publicación</th><th>Visibilidad</th><th><span class="sr-only">Acciones</span></th></tr></thead>
        <tbody>
        @forelse($workshops as $workshop)
        <tr>
            <td><strong>{{ $workshop->name }}</strong><small class="muted">{{ $workshop->summary }}</small></td>
            <td data-label="Nivel">{{ $workshop->grade_level }}</td>
            <td data-label="Verificación">{{ $workshop->verified_at?->format('d/m/Y') ?: 'Pendiente' }}</td>
            <td data-label="Publicación"><span class="status-chip {{ $workshop->status === 'published' ? 'published' : 'draft' }}"><i class="fa-solid {{ $workshop->status === 'published' ? 'fa-circle-check' : 'fa-pen-ruler' }}"></i>{{ $workshop->status === 'published' ? 'Publicado' : 'Borrador' }}</span></td>
            <td data-label="Visibilidad">
                @if($workshop->status === 'published')
                <span class="status-chip {{ $workshop->is_active ? 'active' : 'inactive' }}"><i class="fa-solid {{ $workshop->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>{{ $workshop->is_active ? 'Activo' : 'Inactivo' }}</span>
                @else
                <span class="status-chip neutral">No aplica</span>
                @endif
            </td>
            <td>
                <div class="row-actions" aria-label="Acciones para {{ $workshop->name }}">
                    @if($workshop->status === 'published' && $workshop->is_active)
                    <a class="icon-action" href="{{ route('workshops.show', $workshop) }}" target="_blank" title="Ver en el sitio" aria-label="Ver en el sitio"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    @endif
                    @if(auth()->user()->hasPermission('workshops.manage'))
                        @if($workshop->status === 'published')
                        <form method="POST" action="{{ route('admin.workshops.toggle', $workshop) }}">@csrf @method('PUT')
                            <button class="icon-action {{ $workshop->is_active ? 'visibility-on' : 'visibility-off' }}" type="submit" title="{{ $workshop->is_active ? 'Ocultar del sitio' : 'Mostrar en el sitio' }}" aria-label="{{ $workshop->is_active ? 'Ocultar del sitio' : 'Mostrar en el sitio' }}"><i class="fa-solid {{ $workshop->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i></button>
                        </form>
                        @endif
                    <a class="icon-action" href="{{ route('admin.workshops.edit', $workshop) }}" title="Editar" aria-label="Editar"><i class="fa-solid fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.workshops.destroy', $workshop) }}" onsubmit="return confirm('¿Eliminar este taller definitivamente?')">@csrf @method('DELETE')
                        <button class="icon-action danger" type="submit" title="Eliminar" aria-label="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">No hay talleres registrados. Agregue solo nombres confirmados.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
