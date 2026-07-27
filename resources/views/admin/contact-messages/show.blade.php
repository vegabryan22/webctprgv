@extends('layouts.admin')

@section('title', 'Consulta de '.$contactMessage->name)

@section('content')
<div class="page-heading">
    <div><h1><i class="fa-solid fa-envelope-open-text"></i> {{ $contactMessage->subject }}</h1><p class="muted">Recibida el {{ $contactMessage->created_at->format('d/m/Y \a \l\a\s H:i') }}</p></div>
    <a class="button ghost" href="{{ route('admin.contact-messages.index') }}">Volver a consultas</a>
</div>

<div class="card">
    <dl class="detail-list">
        <dt>Nombre</dt><dd>{{ $contactMessage->name }}</dd>
        <dt>Correo</dt><dd><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></dd>
        @if($contactMessage->phone)<dt>Teléfono</dt><dd><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactMessage->phone) }}">{{ $contactMessage->phone }}</a></dd>@endif
        <dt>Mensaje</dt><dd>{!! nl2br(e($contactMessage->message)) !!}</dd>
    </dl>
</div>

<form class="card" method="POST" action="{{ route('admin.contact-messages.update', $contactMessage) }}">
    @csrf
    @method('PUT')
    <div class="field">
        <label for="status">Estado de atención</label>
        <select id="status" name="status">
            @foreach(['new' => 'Nuevo', 'read' => 'Leído', 'handled' => 'Atendido', 'archived' => 'Archivado'] as $value => $label)
                <option value="{{ $value }}" @selected($contactMessage->status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Actualizar estado</button>
</form>
@endsection
