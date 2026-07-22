<nav class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" aria-label="Ir al inicio">
            <img src="{{ asset('images/escudo.png') }}" alt="Logo CTP Roberto Gamboa Valverde">
        </a>
    </div>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="public-navigation" aria-label="Abrir menú">
        <i class="fas fa-bars"></i>
    </button>
    <ul class="nav-links" id="public-navigation">
        @foreach ($navigationItems as $item)
            <li>
                <a href="{{ $item->route_name && Route::has($item->route_name) ? route($item->route_name) : $item->url }}" class="nav-link" @if($item->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                    <button type="button"><span>{{ $item->label }}</span></button>
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
