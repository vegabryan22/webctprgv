@props(['documents'])
@if($documents->isNotEmpty())
<div class="curricular-documents">
    @foreach($documents as $document)
    <article class="curricular-document">
        <div class="curricular-document__icon"><i class="fa-solid fa-file-pdf"></i></div>
        <div class="curricular-document__body">
            <span>{{ $document->grade_level }} · {{ $document->language === 'en' ? 'Inglés' : 'Español' }}</span>
            <h3>{{ $document->title }}</h3>
            <div class="curricular-document__actions">
                <a href="{{ asset($document->file_path) }}" target="_blank" rel="noopener">
                    Abrir <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <a href="{{ asset($document->file_path) }}" download>
                    Descargar <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>
    </article>
    @endforeach
</div>
@endif
