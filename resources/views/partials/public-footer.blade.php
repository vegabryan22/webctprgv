<footer class="site-footer" id="contacto">
    <div class="site-footer__shell">
        <div class="site-footer__main">
            <div class="site-footer__brand">
                <img src="{{ asset('images/escudo.png') }}" alt="" width="58" height="58">
                <div><strong>CTP Roberto Gamboa Valverde</strong><p>Educación pública técnica al servicio de nuestra comunidad.</p></div>
            </div>

            <nav class="site-footer__links" aria-label="Oferta educativa">
                <strong>Oferta educativa</strong>
                <a href="{{ route('workshops') }}">Talleres exploratorios</a>
                <a href="{{ route('specialties') }}">Especialidades técnicas</a>
                <a href="{{ route('experiences.index') }}">Práctica profesional</a>
            </nav>

            <nav class="site-footer__links" aria-label="Información institucional">
                <strong>Institución</strong>
                <a href="{{ route('information') }}">Información</a>
                <a href="{{ route('services.index') }}">Servicios</a>
                <a href="{{ route('calendar.index') }}">Calendario</a>
                <a href="{{ route('contact') }}">Contacto</a>
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
