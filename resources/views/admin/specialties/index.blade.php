@extends('layouts.admin')
@section('title', 'Especialidades')
@section('content')
<div class="page-heading"><div><h1><i class="fa-solid fa-screwdriver-wrench"></i> Especialidades</h1><p class="muted">Fichas de la oferta técnica sujetas a verificación institucional.</p></div><div class="actions"><a class="button ghost" href="{{ route('specialties') }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver oferta</a>@if(auth()->user()->hasPermission('specialties.manage'))<a class="button" href="{{ route('admin.specialties.create') }}"><i class="fa-solid fa-plus"></i> Nueva especialidad</a>@endif</div></div>
<div class="card table-wrap"><table><thead><tr><th>Especialidad</th><th>Verificación</th><th>Estado</th><th>Orden</th><th>Acciones</th></tr></thead><tbody>
@forelse($specialties as $specialty)
<tr><td><strong>{{ $specialty->name }}</strong><br><small class="muted">{{ $specialty->summary ?: 'Ficha pendiente de completar' }}</small></td><td>{{ $specialty->verified_at?->format('d/m/Y') ?: 'Pendiente' }}</td><td><span class="badge {{ $specialty->status === 'published' ? 'success' : 'warning' }}">{{ $specialty->status === 'published' ? 'Publicada' : 'Borrador' }}</span></td><td>{{ $specialty->sort_order }}</td><td><div class="actions">
@if($specialty->status === 'published')<a class="button link" href="{{ route('specialties.show', $specialty) }}" target="_blank">Ver</a>@endif
@if(auth()->user()->hasPermission('specialties.manage'))
<form method="POST" action="{{ route('admin.specialties.toggle', $specialty) }}">@csrf @method('PUT')<button class="button link"><i class="fa-solid {{ $specialty->status === 'published' ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i> {{ $specialty->status === 'published' ? 'Desactivar' : 'Activar' }}</button></form>
<a class="button link" href="{{ route('admin.specialties.edit', $specialty) }}"><i class="fa-solid fa-pen"></i> Editar</a>
<form method="POST" action="{{ route('admin.specialties.destroy', $specialty) }}" onsubmit="return confirm('¿Eliminar esta especialidad?')">@csrf @method('DELETE')<button class="button link">Eliminar</button></form>
@endif
</div></td></tr>
@empty<tr><td colspan="5">No hay especialidades registradas.</td></tr>@endforelse
</tbody></table></div>
@endsection
