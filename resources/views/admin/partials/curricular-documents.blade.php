@php
    $gradeOptions = ['7.º', '8.º', '9.º', '10.º', '11.º', '12.º', '7.º, 8.º y 9.º'];
    $defaultGrades = $owner instanceof \App\Models\Specialty
        ? ['10.º', '11.º', '12.º']
        : [$owner->grade_level ?: '7.º', $owner->grade_level ?: '7.º', $owner->grade_level ?: '7.º'];
@endphp
<section class="form-section">
    <div class="form-section__heading">
        <div>
            <h2>Planes de estudio</h2>
            <p class="muted">Adjunte archivos PDF y seleccione el nivel e idioma de cada uno.</p>
        </div>
    </div>

    @if($owner->exists && $owner->curricularDocuments->isNotEmpty())
    <div class="admin-plan-list">
        @foreach($owner->curricularDocuments as $document)
        <label class="admin-plan-item">
            <i class="fa-solid fa-file-pdf"></i>
            <span>
                <strong>{{ $document->title }}</strong>
                <small>{{ $document->grade_level }} · {{ $document->language === 'en' ? 'Inglés' : 'Español' }}</small>
            </span>
            <a href="{{ asset($document->file_path) }}" target="_blank" rel="noopener">Abrir</a>
            <span class="admin-plan-delete">
                <input type="checkbox" name="delete_plan_ids[]" value="{{ $document->id }}">
                Quitar
            </span>
        </label>
        @endforeach
    </div>
    @endif

    <div class="admin-plan-uploads">
        @for($index = 0; $index < 3; $index++)
        <div class="admin-plan-upload">
            <div class="field"><label>Archivo PDF</label><input type="file" name="plan_files[{{ $index }}]" accept="application/pdf"></div>
            <div class="field"><label>Nivel</label><select name="plan_grades[{{ $index }}]">@foreach($gradeOptions as $grade)<option value="{{ $grade }}" @selected(old("plan_grades.$index", $defaultGrades[$index]) === $grade)>{{ $grade }}</option>@endforeach</select></div>
            <div class="field"><label>Idioma</label><select name="plan_languages[{{ $index }}]"><option value="es">Español</option><option value="en" @selected(old("plan_languages.$index") === 'en')>Inglés</option></select></div>
            <div class="field"><label>Título opcional</label><input name="plan_titles[{{ $index }}]" value="{{ old("plan_titles.$index") }}" placeholder="Programa de estudio"></div>
        </div>
        @endfor
    </div>
</section>
