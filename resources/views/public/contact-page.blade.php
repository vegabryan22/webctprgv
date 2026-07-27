@extends('layouts.public')

@section('title', $page->title.' - CTP Roberto Gamboa Valverde')

@section('content')
@php
    $phone = $contact['contact_phone'] ?? null;
    $secondaryPhone = $contact['contact_phone_secondary'] ?? null;
    $email = $contact['contact_email'] ?? null;
    $hours = $contact['contact_hours'] ?? null;
    $address = $contact['contact_address'] ?? null;
    $mapUrl = $contact['contact_map_url'] ?? null;
@endphp
<main class="contact-page">
    <header class="contact-hero">
        <div class="contact-shell">
            <span class="contact-eyebrow">Atención institucional</span>
            <h1>{{ $contact['contact_heading'] ?? 'Contacto' }}</h1>
            <p>{{ $contact['contact_intro'] ?? 'Consulte nuestros canales oficiales de atención.' }}</p>
        </div>
    </header>

    <section class="contact-content">
        <div class="contact-shell">
            <header class="contact-section-heading">
                <span class="contact-eyebrow">Canales oficiales</span>
                <h2>¿Cómo podemos ayudarle?</h2>
                <p>Seleccione el medio más conveniente para comunicarse con la institución.</p>
            </header>

            <div class="contact-grid">
                @if($phone || $secondaryPhone)
                    <article class="contact-card">
                        <i class="fa-solid fa-phone"></i>
                        <div><span>Atención telefónica</span><h2>Teléfonos</h2>
                            @if($phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>@endif
                            @if($secondaryPhone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $secondaryPhone) }}">{{ $secondaryPhone }}</a>@endif
                        </div>
                    </article>
                @endif

                @if($email)
                    <article class="contact-card">
                        <i class="fa-solid fa-envelope"></i>
                        <div><span>Consultas generales</span><h2>Correo electrónico</h2><a href="mailto:{{ $email }}">{{ $email }}</a></div>
                    </article>
                @endif

                @if($hours)
                    <article class="contact-card">
                        <i class="fa-solid fa-clock"></i>
                        <div><span>Disponibilidad</span><h2>Horario</h2><p>{{ $hours }}</p></div>
                    </article>
                @endif

                @if($address)
                    <article class="contact-card">
                        <i class="fa-solid fa-location-dot"></i>
                        <div><span>Visítenos</span><h2>Ubicación</h2><p>{{ $address }}</p>
                            @if($mapUrl)<a class="contact-card__action" href="{{ $mapUrl }}" target="_blank" rel="noopener">Abrir mapa <i class="fa-solid fa-arrow-up-right-from-square"></i></a>@endif
                        </div>
                    </article>
                @endif
            </div>

            @unless($phone || $secondaryPhone || $email || $hours || $address)
                <div class="contact-empty"><i class="fa-solid fa-address-card"></i><h2>Canales pendientes de confirmación</h2><p>La información se publicará cuando sea verificada por la institución.</p></div>
            @endunless

            @if(!empty($contact['contact_verified_at']) || !empty($contact['contact_source']))
                <p class="contact-verification"><i class="fa-solid fa-circle-check"></i>
                    @if(!empty($contact['contact_verified_at'])) Verificado el {{ \Illuminate\Support\Carbon::parse($contact['contact_verified_at'])->format('d/m/Y') }}.@endif
                    @if(!empty($contact['contact_source'])) Fuente: {{ $contact['contact_source'] }}.@endif
                </p>
            @endif

            <aside class="contact-directory-callout">
                <div><i class="fa-solid fa-address-book"></i><span><strong>¿Busca un departamento específico?</strong><small>Consulte responsables, extensiones y horarios publicados.</small></span></div>
                <a href="{{ route('directory') }}">Ver directorio <i class="fa-solid fa-arrow-right"></i></a>
            </aside>
        </div>
    </section>
</main>
@endsection
