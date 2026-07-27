@props(['documents'])
@if($documents->isNotEmpty())
<div class="curricular-documents">
    @foreach($documents as $document)
    <article class="curricular-document">
        <div class="curricular-document__icon"><i class="fa-solid fa-file-pdf"></i></div>
        <div class="curricular-document__body">
            <h3>{{ $document->title }}</h3>
        </div>
        <div class="curricular-document__actions">
            <a href="{{ asset($document->file_path) }}" target="_blank" rel="noopener" aria-label="Abrir {{ $document->title }}" title="Abrir">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
            <a href="{{ asset($document->file_path) }}" download aria-label="Descargar {{ $document->title }}" title="Descargar">
                <i class="fa-solid fa-download"></i>
            </a>
        </div>
    </article>
    @endforeach
</div>
@endif
