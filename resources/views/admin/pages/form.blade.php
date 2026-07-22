@extends('layouts.admin')
@section('title', $page->exists ? 'Editar página' : 'Nueva página')
@section('content')
<div class="page-heading"><h1><i class="fa-solid fa-file-pen"></i> {{ $page->exists ? 'Editar página' : 'Nueva página' }}</h1><a class="button ghost" href="{{ route('admin.pages.index') }}"><i class="fa-solid fa-arrow-left"></i> Volver</a></div>
<form class="card" method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}">@csrf @if($page->exists) @method('PUT') @endif
@if($page->is_system)<div class="alert"><i class="fa-solid fa-circle-info"></i> Esta es una página institucional. Puede editar su contenido y publicación, pero su ruta y comportamiento técnico están protegidos.</div>@endif
<div class="field-grid"><div class="field"><label for="title">Título</label><input id="title" name="title" value="{{ old('title', $page->title) }}" required></div><div class="field"><label for="slug">Dirección amigable</label><input id="slug" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="ejemplo-de-pagina" required @readonly($page->is_system)></div></div>
<div class="field"><label for="summary">Resumen</label><textarea id="summary" name="summary">{{ old('summary', $page->summary) }}</textarea></div>
<div class="field"><div class="editor-heading"><label for="content">Contenido</label>@if($page->exists && $page->status === 'published')<a class="button ghost" target="_blank" href="{{ $page->route_name ? route($page->route_name) : route('pages.show', $page) }}"><i class="fa-solid fa-eye"></i> Vista publicada</a>@endif</div>
<div class="editor-tabs"><button class="button editor-tab active" type="button" data-editor-mode="visual"><i class="fa-solid fa-wand-magic-sparkles"></i> Visual</button><button class="button editor-tab" type="button" data-editor-mode="html"><i class="fa-solid fa-code"></i> HTML</button></div>
<div class="editor-toolbar" id="editor-toolbar"><button type="button" data-command="bold" title="Negrita"><i class="fa-solid fa-bold"></i></button><button type="button" data-command="italic" title="Cursiva"><i class="fa-solid fa-italic"></i></button><button type="button" data-command="underline" title="Subrayado"><i class="fa-solid fa-underline"></i></button><span></span><button type="button" data-block="h2">H2</button><button type="button" data-block="h3">H3</button><button type="button" data-block="p">P</button><span></span><button type="button" data-command="insertUnorderedList" title="Lista"><i class="fa-solid fa-list-ul"></i></button><button type="button" data-command="insertOrderedList" title="Lista numerada"><i class="fa-solid fa-list-ol"></i></button><button type="button" data-create-link title="Enlace"><i class="fa-solid fa-link"></i></button><button type="button" data-command="removeFormat" title="Limpiar formato"><i class="fa-solid fa-eraser"></i></button></div>
<div class="visual-editor" id="visual-editor" contenteditable="true" aria-label="Editor visual"></div>
<textarea class="code-editor" id="content" name="content" rows="24" hidden>{{ old('content', $page->content) }}</textarea><small class="muted">Use el modo Visual para cambios comunes o HTML para estructuras avanzadas. Se eliminan scripts, eventos y URLs peligrosas al guardar.</small></div>
<div class="field"><label for="status">Estado</label><select id="status" name="status"><option value="draft" @selected(old('status', $page->status ?: 'draft') === 'draft')>Borrador</option>@if(auth()->user()->hasPermission('pages.publish'))<option value="published" @selected(old('status', $page->status) === 'published')>Publicada</option>@endif<option value="archived" @selected(old('status', $page->status) === 'archived')>Archivada</option></select></div>
<button class="button secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar página</button></form>
@endsection

@push('scripts')
<script>
(() => {
    const form = document.querySelector('form.card');
    const source = document.getElementById('content');
    const visual = document.getElementById('visual-editor');
    const toolbar = document.getElementById('editor-toolbar');
    const tabs = document.querySelectorAll('[data-editor-mode]');
    if (!form || !source || !visual) return;

    visual.innerHTML = source.value;
    tabs.forEach(tab => tab.addEventListener('click', () => {
        const visualMode = tab.dataset.editorMode === 'visual';
        if (visualMode) visual.innerHTML = source.value;
        else source.value = visual.innerHTML;
        visual.hidden = !visualMode;
        toolbar.hidden = !visualMode;
        source.hidden = visualMode;
        tabs.forEach(item => item.classList.toggle('active', item === tab));
    }));

    toolbar.querySelectorAll('[data-command]').forEach(button => button.addEventListener('click', () => {
        visual.focus();
        document.execCommand(button.dataset.command, false);
    }));
    toolbar.querySelectorAll('[data-block]').forEach(button => button.addEventListener('click', () => {
        visual.focus();
        document.execCommand('formatBlock', false, button.dataset.block);
    }));
    toolbar.querySelector('[data-create-link]').addEventListener('click', () => {
        const url = prompt('Dirección del enlace (https://...)');
        if (url) document.execCommand('createLink', false, url);
    });
    form.addEventListener('submit', () => {
        if (!visual.hidden) source.value = visual.innerHTML;
    });
})();
</script>
@endpush
