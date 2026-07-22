<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') · CTPRGV</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/escudo.png') }}" alt="Escudo">
            <span>CTPRGV<br><small>Administración</small></span>
        </a>
        <nav>
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Resumen</a>
            @if(auth()->user()->hasPermission('pages.view'))
                <p class="nav-section">Contenido</p>
                <a class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">Páginas</a>
            @endif
            @if(auth()->user()->hasPermission('users.view') || auth()->user()->hasPermission('roles.view'))
                <p class="nav-section">Seguridad</p>
                @if(auth()->user()->hasPermission('users.view'))<a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Usuarios</a>@endif
                @if(auth()->user()->hasPermission('roles.view'))<a class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">Roles y permisos</a>@endif
            @endif
            @if(auth()->user()->hasPermission('settings.manage'))
                <p class="nav-section">Sistema</p>
                <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">Configuración</a>
            @endif
        </nav>
    </aside>
    <div class="admin-main">
        <header class="topbar">
            <a href="{{ route('home') }}" target="_blank">Ver sitio</a>
            <div class="actions">
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="button link" type="submit">Salir</button></form>
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
</body>
</html>
