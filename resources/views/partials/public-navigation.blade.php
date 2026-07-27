@php
    $navigationIcons = [
        'home' => 'fa-house',
        'news' => 'fa-newspaper',
        'information' => 'fa-school',
        'specialties' => 'fa-screwdriver-wrench',
        'admission' => 'fa-user-check',
        'board' => 'fa-people-group',
        'contact' => 'fa-envelope',
        'calendar.index' => 'fa-calendar-days',
        'services.index' => 'fa-hand-holding-heart',
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
    @guest
        <a class="session-link" href="{{ route('login') }}"><i class="fas fa-right-to-bracket" aria-hidden="true"></i><span>Iniciar sesión</span></a>
    @else
        @if(auth()->user()->hasPermission('admin.access'))
            <a class="session-link admin" href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge-high" aria-hidden="true"></i><span>Administración</span></a>
        @endif
    @endguest
</nav>
