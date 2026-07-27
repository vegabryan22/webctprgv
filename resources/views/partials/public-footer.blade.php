<footer class="site-footer" id="contacto">
    <div class="site-footer__shell">
        <div class="site-footer__main">
            <div class="site-footer__brand">
                <img src="{{ asset('images/escudo.png') }}" alt="" width="58" height="58">
                <div><strong>CTP Roberto Gamboa Valverde</strong><p>Educación pública técnica al servicio de nuestra comunidad.</p></div>
            </div>

            <nav class="site-footer__links" aria-label="Oferta educativa">
                <strong>Oferta educativa</strong>
                @if($siteSections->get('workshops', true))
                <a href="{{ route('workshops') }}">Talleres exploratorios</a>
                @endif
                @if($siteSections->get('specialties', true))
                <a href="{{ route('specialties') }}">Especialidades técnicas</a>
                @endif
                @if($siteSections->get('practice', true))
                <a href="{{ route('experiences.index') }}">Práctica profesional</a>
                @endif
            </nav>

            <nav class="site-footer__links" aria-label="Información institucional">
                <strong>Institución</strong>
                @if($siteSections->get('institution', true))
                <a href="{{ route('information') }}">Nuestra institución</a>
                @endif
                @if($siteSections->get('services', true))
                <a href="{{ route('services.index') }}">Servicios</a>
                @endif
                @if($siteSections->get('calendar', true))
                <a href="{{ route('calendar.index') }}">Calendario</a>
                @endif
                @if($siteSections->get('contact', true))
                <a href="{{ route('contact') }}">Contacto</a>
                @endif
            </nav>

            <div class="site-footer__connect">
                <strong>Síganos</strong>
                <div>
                    @foreach (config('site.social') as $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                        <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>© {{ now()->year }} CTP Roberto Gamboa Valverde</span>
            <span>Departamento de Redes · Prof. Bryan Vega Rondón y estudiantes de 12.º año · v{{ config('version.number') }}</span>
        </div>
    </div>
</footer>
