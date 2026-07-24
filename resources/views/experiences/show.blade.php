@extends('layouts.public')
@section('title', $experience->title.' - CTP Roberto Gamboa Valverde')
@section('content')
<main class="service-page"><header class="service-hero"><div><span>{{ $experience->typeLabel() }}</span><h1>{{ $experience->title }}</h1><p>{{ $experience->summary }}</p></div></header><article class="service-shell experience-detail">
<div class="experience-facts"><div><strong>Responsable</strong><span>{{ $experience->responsible }}</span></div>@if($experience->duration)<div><strong>Duración</strong><span>{{ $experience->duration }}</span></div>@endif @if($experience->schedule)<div><strong>Periodo u horario</strong><span>{{ $experience->schedule }}</span></div>@endif<div><strong>Información verificada</strong><span>{{ $experience->verified_at->format('d/m/Y') }}</span></div></div>
@if($experience->description)<section><h2>Descripción</h2>{!! $experience->description !!}</section>@endif
@if($experience->requirements)<section><h2>Requisitos</h2>{!! $experience->requirements !!}</section>@endif
@if($experience->process_stages)<section><h2>Etapas del proceso</h2>{!! $experience->process_stages !!}</section>@endif
@if($experience->specialties->isNotEmpty())<section><h2>Especialidades relacionadas</h2><div class="document-tags">@foreach($experience->specialties as $specialty)<a href="{{ route('specialties.show', $specialty) }}">{{ $specialty->name }}</a>@endforeach</div></section>@endif
@if($experience->documents->isNotEmpty())<section><h2>Documentos vigentes</h2><div class="document-list">@foreach($experience->documents as $document)<a href="{{ Storage::url($document->file_path) }}" target="_blank" rel="noopener"><i class="fa-regular fa-file-lines"></i><span><strong>{{ $document->title }}</strong><small>{{ $document->version ? 'Versión '.$document->version.' · ' : '' }}{{ $document->responsible }}</small></span><i class="fa-solid fa-download"></i></a>@endforeach</div></section>@endif
<section class="company-contact"><h2>Contacto institucional</h2>@if($experience->contact_email)<p>Estudiantes y familias: <a href="mailto:{{ $experience->contact_email }}">{{ $experience->contact_email }}</a></p>@endif @if($experience->company_contact_email)<p>Empresas interesadas: <a href="mailto:{{ $experience->company_contact_email }}">{{ $experience->company_contact_email }}</a></p>@endif @if(!$experience->contact_email && !$experience->company_contact_email)<p>El canal de contacto está pendiente de confirmación institucional.</p>@endif</section>
</article></main>
@endsection
