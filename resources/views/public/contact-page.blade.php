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
            <div class="contact-primary">
                <section class="contact-form-section" id="formulario-contacto">
                    <div class="contact-form-section__intro">
                        <span class="contact-eyebrow">Escríbanos</span>
                        <h2>Envíe su consulta</h2>
                        <p>Su mensaje quedará registrado para que el personal autorizado pueda darle seguimiento.</p>
                        <div><i class="fa-solid fa-shield-halved"></i><span><strong>Uso responsable de datos</strong><small>Comparta únicamente la información necesaria para atender su consulta.</small></span></div>
                    </div>
                    <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        @if(session('contact_success'))
                            <div class="contact-form__success"><i class="fa-solid fa-circle-check"></i> {{ session('contact_success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="contact-form__errors"><strong>Revise los campos indicados.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <div class="contact-form__grid">
                            <label>Nombre completo<input name="name" value="{{ old('name') }}" maxlength="150" required autocomplete="name"></label>
                            <label>Correo electrónico<input type="email" name="email" value="{{ old('email') }}" maxlength="255" required autocomplete="email"></label>
                            <label>Teléfono (opcional)<input name="phone" value="{{ old('phone') }}" maxlength="40" autocomplete="tel"></label>
                            <label>Asunto<input name="subject" value="{{ old('subject') }}" maxlength="180" required></label>
                        </div>
                        <label>Mensaje<textarea name="message" rows="5" minlength="10" maxlength="5000" required>{{ old('message') }}</textarea></label>
                        <div class="contact-form__trap" aria-hidden="true"><label>Sitio web<input name="website" tabindex="-1" autocomplete="off"></label></div>
                        <label class="contact-form__consent"><input type="checkbox" name="privacy_consent" value="1" @checked(old('privacy_consent')) required> Autorizo el uso de estos datos únicamente para atender y dar seguimiento a mi consulta.</label>
                        <button type="submit">Enviar consulta <i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </section>

                <aside class="contact-channels">
                    <header><span class="contact-eyebrow">Canales oficiales</span><h2>Contacto directo</h2></header>
                    <div class="contact-grid">
                        @if($phone || $secondaryPhone)
                            <article class="contact-card"><i class="fa-solid fa-phone"></i><div><span>Atención telefónica</span><h2>Teléfonos</h2>
                                @if($phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>@endif
                                @if($secondaryPhone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $secondaryPhone) }}">{{ $secondaryPhone }}</a>@endif
                            </div></article>
                        @endif
                        @if($email)
                            <article class="contact-card"><i class="fa-solid fa-envelope"></i><div><span>Consultas generales</span><h2>Correo</h2><a href="mailto:{{ $email }}">{{ $email }}</a></div></article>
                        @endif
                        @if($hours)
                            <article class="contact-card"><i class="fa-solid fa-clock"></i><div><span>Disponibilidad</span><h2>Horario</h2><p>{{ $hours }}</p></div></article>
                        @endif
                    </div>
                    <nav class="contact-socials" aria-label="Redes sociales institucionales">
                        <div><span class="contact-eyebrow">También en redes</span><strong>Síganos</strong></div>
                        <div>
                            @foreach(config('site.social') as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}"><i class="{{ $social['icon'] }}" aria-hidden="true"></i><span>{{ $social['label'] }}</span></a>
                            @endforeach
                        </div>
                    </nav>
                    @if(!empty($contact['contact_verified_at']) || !empty($contact['contact_source']))
                        <p class="contact-verification"><i class="fa-solid fa-circle-check"></i>
                            @if(!empty($contact['contact_verified_at'])) Verificado el {{ \Illuminate\Support\Carbon::parse($contact['contact_verified_at'])->format('d/m/Y') }}.@endif
                            @if(!empty($contact['contact_source'])) Fuente: {{ $contact['contact_source'] }}.@endif
                        </p>
                    @endif
                </aside>
            </div>

            @if($address)
                <article class="contact-card contact-card--location">
                    <i class="fa-solid fa-location-dot"></i>
                    <div><span>Visítenos</span><h2>Ubicación</h2><p>{{ $address }}</p>
                        @if($mapUrl)<a class="contact-card__action" href="{{ $mapUrl }}" target="_blank" rel="noopener">Abrir mapa <i class="fa-solid fa-arrow-up-right-from-square"></i></a>@endif
                    </div>
                    <div class="contact-map"><iframe src="https://www.google.com/maps?q={{ urlencode($address) }}&amp;output=embed" title="Mapa de ubicación del CTP Roberto Gamboa Valverde" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </article>
            @endif

            <aside class="contact-directory-callout">
                <div><i class="fa-solid fa-address-book"></i><span><strong>¿Busca un departamento específico?</strong><small>Consulte responsables, extensiones y horarios publicados.</small></span></div>
                <a href="{{ route('directory') }}">Ver directorio <i class="fa-solid fa-arrow-right"></i></a>
            </aside>
        </div>
    </section>
</main>
@endsection
