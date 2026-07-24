<footer class="footer" id="contacto">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <h3>CTP Roberto Gamboa Valverde</h3>
                <p>Formando técnicos competentes para el desarrollo del país</p>
            </div>
            <div class="footer-social">
                @foreach (config('site.social') as $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ now()->year }} Departamento de Redes · Prof. Bryan Vega Rondón y estudiantes de 12.º año · v{{ config('version.number') }}</p>
        </div>
    </div>
</footer>
