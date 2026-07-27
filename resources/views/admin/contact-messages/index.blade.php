@extends('layouts.admin')

@section('title', 'Consultas recibidas')

@section('content')
<div class="page-heading">
    <div><h1><i class="fa-solid fa-inbox"></i> Consultas recibidas</h1><p class="muted">Mensajes enviados desde el formulario público.</p></div>
    <a class="button ghost" href="{{ route('admin.contact.edit') }}"><i class="fa-solid fa-sliders"></i> Configurar contacto</a>
</div>

<form class="toolbar" method="GET">
    <select name="status" onchange="this.form.submit()">
        <option value="">Todos los estados</option>
        @foreach(['new' => 'Nuevos', 'read' => 'Leídos', 'handled' => 'Atendidos', 'archived' => 'Archivados'] as $value => $label)
            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
        @endforeach
    </select>
</form>

<div class="card table-wrap">
    <table>
        <thead><tr><th>Fecha</th><th>Remitente</th><th>Asunto</th><th>Estado</th><th></th></tr></thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $message->name }}</strong><br><small>{{ $message->email }}</small></td>
                    <td>{{ $message->subject }}</td>
                    <td><span class="badge {{ $message->status === 'new' ? 'warning' : ($message->status === 'handled' ? 'success' : '') }}">{{ ['new' => 'Nuevo', 'read' => 'Leído', 'handled' => 'Atendido', 'archived' => 'Archivado'][$message->status] }}</span></td>
                    <td><a class="button link" href="{{ route('admin.contact-messages.show', $message) }}">Abrir</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No hay consultas en este estado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $messages->links() }}
@endsection
