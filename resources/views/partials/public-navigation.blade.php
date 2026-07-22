<nav class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" aria-label="Ir al inicio">
            <img src="{{ asset('images/escudo.png') }}" alt="Logo CTP Roberto Gamboa Valverde">
        </a>
    </div>
    <ul class="nav-links">
        @foreach (config('site.navigation') as $item)
            <li>
                <a href="{{ route($item['route']) }}" class="nav-link">
                    <button type="button"><span>{{ $item['label'] }}</span></button>
                </a>
            </li>
        @endforeach
    </ul>
    <ul class="wrapper">
        @foreach (config('site.social') as $network => $social)
            <li class="icon {{ $network }}">
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
                    <i class="{{ $social['icon'] }}"></i>
                    <span class="tooltip">{{ $social['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
