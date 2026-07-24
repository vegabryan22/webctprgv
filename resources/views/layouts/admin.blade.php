<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') · CTPRGV</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ config('version.number') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/escudo.png') }}" alt="Escudo">
            <span>CTPRGV<br><small>Administración</small></span>
        </a>
        <nav>
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line"></i><span>Resumen</span></a>
            @if(auth()->user()->hasPermission('pages.view') || auth()->user()->hasPermission('news.view') || auth()->user()->hasPermission('services.view') || auth()->user()->hasPermission('specialties.view') || auth()->user()->hasPermission('workshops.view') || auth()->user()->hasPermission('menu.view') || auth()->user()->hasPermission('events.view'))
                <p class="nav-section">Contenido</p>
                @if(auth()->user()->hasPermission('pages.view'))<a class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><i class="fa-regular fa-file-lines"></i><span>Páginas</span></a>@endif
                @if(auth()->user()->hasPermission('pages.view'))<a class="{{ request()->routeIs('admin.content-audit.*') ? 'active' : '' }}" href="{{ route('admin.content-audit.index') }}"><i class="fa-solid fa-magnifying-glass-chart"></i><span>Revisión editorial</span></a>@endif
                @if(auth()->user()->hasPermission('news.view'))<a class="{{ request()->routeIs('admin.news.*') || request()->routeIs('admin.news-categories.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}"><i class="fa-regular fa-newspaper"></i><span>Noticias</span></a>@endif
                @if(auth()->user()->hasPermission('services.view'))<a class="{{ request()->routeIs('admin.services.*') || request()->routeIs('admin.service-categories.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}"><i class="fa-solid fa-hand-holding-heart"></i><span>Servicios</span></a>@endif
                @if(auth()->user()->hasPermission('specialties.view'))<a class="{{ request()->routeIs('admin.specialties.*') ? 'active' : '' }}" href="{{ route('admin.specialties.index') }}"><i class="fa-solid fa-screwdriver-wrench"></i><span>Especialidades</span></a>@endif
                @if(auth()->user()->hasPermission('workshops.view'))<a class="{{ request()->routeIs('admin.workshops.*') ? 'active' : '' }}" href="{{ route('admin.workshops.index') }}"><i class="fa-solid fa-compass-drafting"></i><span>Talleres exploratorios</span></a>@endif
                @if(auth()->user()->hasPermission('menu.view'))<a class="{{ request()->routeIs('admin.navigation.*') ? 'active' : '' }}" href="{{ route('admin.navigation.index') }}"><i class="fa-solid fa-bars"></i><span>Menú principal</span></a>@endif
                @if(auth()->user()->hasPermission('events.view'))<a class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="fa-regular fa-calendar-days"></i><span>Actividades</span></a>@endif
                @if(auth()->user()->hasPermission('events.manage'))<a class="{{ request()->routeIs('admin.event-categories.*') ? 'active' : '' }}" href="{{ route('admin.event-categories.index') }}"><i class="fa-solid fa-tags"></i><span>Categorías</span></a>@endif
            @endif
            @if(auth()->user()->hasPermission('users.view') || auth()->user()->hasPermission('roles.view'))
                <p class="nav-section">Seguridad</p>
                @if(auth()->user()->hasPermission('users.view'))<a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users"></i><span>Usuarios</span></a>@endif
                @if(auth()->user()->hasPermission('roles.view'))<a class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="fa-solid fa-shield-halved"></i><span>Roles y permisos</span></a>@endif
            @endif
            @if(auth()->user()->hasPermission('settings.manage'))
                <p class="nav-section">Sistema</p>
                <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><i class="fa-solid fa-sliders"></i><span>Configuración</span></a>
            @endif
            @if(auth()->user()->hasPermission('gitops.view'))
                <p class="nav-section">Operaciones</p>
                <a class="{{ request()->routeIs('admin.gitops.*') ? 'active' : '' }}" href="{{ route('admin.gitops.index') }}"><i class="fa-brands fa-github"></i><span>GitHub GitOps</span></a>
            @endif
        </nav>
    </aside>
    <div class="admin-main">
        <header class="topbar">
            <a class="topbar-link" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Ver sitio</a>
            <div class="actions">
                <span><i class="fa-regular fa-circle-user"></i> {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="button ghost" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Salir</button></form>
            </div>
        </header>
        <main class="content">
            @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert error"><strong>Revise la información:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
