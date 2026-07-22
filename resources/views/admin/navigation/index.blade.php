@extends('layouts.admin')

@section('title', 'Menú principal')

@section('content')
<div class="page-heading">
    <div><h1><i class="fa-solid fa-bars"></i> Menú principal</h1><p class="muted">Controle las opciones que aparecen en la navegación pública.</p></div>
    <a class="button ghost" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver menú publicado</a>
</div>

<div class="alert"><i class="fa-solid fa-circle-info"></i> Los elementos se muestran de menor a mayor según el campo “Orden”. Ocultar o eliminar una opción no elimina la página asociada.</div>

<section class="stack">
    @foreach($items as $item)
        <form class="card menu-item-form" method="POST" action="{{ route('admin.navigation.update', $item) }}">
            @csrf @method('PUT')
            <div class="menu-item-grid">
                <div class="field"><label for="label_{{ $item->id }}">Etiqueta</label><input id="label_{{ $item->id }}" name="label" value="{{ old('label', $item->label) }}" required></div>
                <div class="field"><label for="route_{{ $item->id }}">Página interna</label><select id="route_{{ $item->id }}" name="route_name"><option value="">Enlace externo</option>@foreach($pages as $page)<option value="{{ $page->route_name }}" @selected($item->route_name === $page->route_name)>{{ $page->title }}</option>@endforeach</select></div>
                <div class="field"><label for="url_{{ $item->id }}">URL externa</label><input id="url_{{ $item->id }}" type="url" name="url" value="{{ old('url', $item->url) }}" placeholder="https://..."></div>
                <div class="field order-field"><label for="order_{{ $item->id }}">Orden</label><input id="order_{{ $item->id }}" type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $item->sort_order) }}" required></div>
            </div>
            <div class="menu-item-footer">
                <div class="actions"><label class="toggle"><input type="checkbox" name="is_active" value="1" @checked($item->is_active)><span>Visible</span></label><label class="toggle"><input type="checkbox" name="open_in_new_tab" value="1" @checked($item->open_in_new_tab)><span>Nueva pestaña</span></label></div>
                @if(auth()->user()->hasPermission('menu.manage'))<div class="actions"><button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar</button></form><form method="POST" action="{{ route('admin.navigation.destroy', $item) }}" onsubmit="return confirm('¿Quitar esta opción del menú?')">@csrf @method('DELETE')<button class="button danger" type="submit"><i class="fa-regular fa-trash-can"></i> Quitar</button></form></div>@else</form>@endif
            </div>
    @endforeach
</section>

@if(auth()->user()->hasPermission('menu.manage'))
<section class="card" style="margin-top: 1rem">
    <div class="page-heading"><div><h2><i class="fa-solid fa-plus"></i> Añadir opción</h2><p class="muted">Enlace a una página institucional o a una dirección externa.</p></div></div>
    <form method="POST" action="{{ route('admin.navigation.store') }}">@csrf
        <div class="menu-item-grid">
            <div class="field"><label for="new_label">Etiqueta</label><input id="new_label" name="label" required></div>
            <div class="field"><label for="new_route">Página interna</label><select id="new_route" name="route_name"><option value="">Enlace externo</option>@foreach($pages as $page)<option value="{{ $page->route_name }}">{{ $page->title }}</option>@endforeach</select></div>
            <div class="field"><label for="new_url">URL externa</label><input id="new_url" name="url" type="url" placeholder="https://..."></div>
            <div class="field order-field"><label for="new_order">Orden</label><input id="new_order" name="sort_order" type="number" min="0" max="9999" value="{{ (($items->max('sort_order') ?? 0) + 10) }}" required></div>
        </div>
        <div class="menu-item-footer"><div class="actions"><label class="toggle"><input type="checkbox" name="is_active" value="1" checked><span>Visible</span></label><label class="toggle"><input type="checkbox" name="open_in_new_tab" value="1"><span>Nueva pestaña</span></label></div><button class="button" type="submit"><i class="fa-solid fa-plus"></i> Añadir al menú</button></div>
    </form>
</section>
@endif
@endsection
