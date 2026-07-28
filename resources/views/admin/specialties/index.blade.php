@extends('layouts.admin')
@section('title', 'Especialidades')
@section('content')
<div class="page-heading">
    <div>
        <h1><i class="fa-solid fa-screwdriver-wrench"></i> Especialidades</h1>
        <p class="muted">La publicación controla la aprobación editorial; la visibilidad permite retirar temporalmente una ficha ya publicada.</p>
    </div>
    <div class="actions">
        <a class="button ghost" href="{{ route('specialties') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Ver oferta</a>
        @if(auth()->user()->hasPermission('specialties.manage'))
        <a class="button" href="{{ route('admin.specialties.create') }}"><i class="fa-solid fa-plus"></i> Nueva especialidad</a>
        @endif
    </div>
</div>

<div class="card table-wrap curricular-admin-table">
    <table>
        <thead><tr><th>Especialidad</th><th>Verificación</th><th>Publicación</th><th>Visibilidad</th><th>Orden</th><th><span class="sr-only">Acciones</span></th></tr></thead>
        <tbody>
        @forelse($specialties as $specialty)
        <tr>
            <td><strong>{{ $specialty->name }}</strong><small class="muted">{{ $specialty->summary ?: 'Ficha pendiente de completar' }}</small></td>
            <td data-label="Verificación">{{ $specialty->verified_at?->format('d/m/Y') ?: 'Pendiente' }}</td>
            <td data-label="Publicación"><span class="status-chip {{ $specialty->status === 'published' ? 'published' : 'draft' }}"><i class="fa-solid {{ $specialty->status === 'published' ? 'fa-circle-check' : 'fa-pen-ruler' }}"></i>{{ $specialty->status === 'published' ? 'Publicada' : 'Borrador' }}</span></td>
            <td data-label="Visibilidad">
                @if($specialty->status === 'published')
                <span class="status-chip {{ $specialty->is_active ? 'active' : 'inactive' }}"><i class="fa-solid {{ $specialty->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>{{ $specialty->is_active ? 'Activa' : 'Inactiva' }}</span>
                @else
                <span class="status-chip neutral">No aplica</span>
                @endif
            </td>
            <td data-label="Orden">{{ $specialty->sort_order }}</td>
            <td>
                <div class="row-actions" aria-label="Acciones para {{ $specialty->name }}">
                    @if($specialty->status === 'published' && $specialty->is_active)
                    <a class="icon-action" href="{{ route('specialties.show', $specialty) }}" target="_blank" title="Ver en el sitio" aria-label="Ver en el sitio"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    @endif
                    @if(auth()->user()->hasPermission('specialties.manage'))
                        @if($specialty->status === 'published')
                        <form method="POST" action="{{ route('admin.specialties.toggle', $specialty) }}">@csrf @method('PUT')
                            <button class="icon-action {{ $specialty->is_active ? 'visibility-on' : 'visibility-off' }}" type="submit" title="{{ $specialty->is_active ? 'Ocultar del sitio' : 'Mostrar en el sitio' }}" aria-label="{{ $specialty->is_active ? 'Ocultar del sitio' : 'Mostrar en el sitio' }}"><i class="fa-solid {{ $specialty->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i></button>
                        </form>
                        @endif
                    <a class="icon-action" href="{{ route('admin.specialties.edit', $specialty) }}" title="Editar" aria-label="Editar"><i class="fa-solid fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.specialties.destroy', $specialty) }}" onsubmit="return confirm('¿Eliminar esta especialidad definitivamente?')">@csrf @method('DELETE')
                        <button class="icon-action danger" type="submit" title="Eliminar" aria-label="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">No hay especialidades registradas.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
