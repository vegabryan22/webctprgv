@php
    $navigationIcons = [
        'home' => 'fa-house',
        'news' => 'fa-newspaper',
        'information' => 'fa-circle-info',
        'specialties' => 'fa-screwdriver-wrench',
        'board' => 'fa-people-group',
        'contact' => 'fa-envelope',
        'calendar.index' => 'fa-calendar-days',
    ];
@endphp
<nav class="navbar site-navbar" aria-label="Navegación principal">
    <a class="site-brand" href="{{ route('home') }}" aria-label="CTP Roberto Gamboa Valverde — Inicio">
        <img src="{{ asset('images/escudo.png') }}" alt="" width="72" height="72">
        <span><strong>CTP</strong><small>Roberto Gamboa Valverde</small></span>
    </a>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="public-navigation" aria-label="Abrir menú">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>
    <ul class="nav-links" id="public-navigation">
        @foreach ($navigationItems as $item)
            @php
                $href = $item->route_name && Route::has($item->route_name) ? route($item->route_name) : $item->url;
                $active = $item->route_name && request()->routeIs($item->route_name, $item->route_name.'.*');
                $icon = $navigationIcons[$item->route_name] ?? 'fa-link';
            @endphp
            <li>
                <a href="{{ $href }}" class="nav-link {{ $active ? 'active' : '' }}" @if($active) aria-current="page" @endif @if($item->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                    <i class="fas {{ $icon }}" aria-hidden="true"></i><span>{{ $item->label }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <ul class="wrapper social-links" aria-label="Redes sociales">
        @foreach (config('site.social') as $network => $social)
            <li class="icon {{ $network }}">
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                    <i class="{{ $social['icon'] }}" aria-hidden="true"></i><span class="tooltip">{{ $social['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
