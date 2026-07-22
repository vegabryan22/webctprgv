<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CTP Roberto Gamboa Valverde')</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ config('version.number') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @include('partials.public-navigation')

    @yield('content')

    @include('partials.public-footer')
    @stack('scripts')
    <script>
        (() => {
            const navbar = document.querySelector('.navbar');
            const toggle = document.querySelector('.nav-toggle');
            if (!navbar || !toggle) return;
            toggle.addEventListener('click', () => {
                const open = navbar.classList.toggle('menu-open');
                toggle.setAttribute('aria-expanded', String(open));
                toggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
                toggle.querySelector('i').className = open ? 'fas fa-xmark' : 'fas fa-bars';
            });
            navbar.querySelectorAll('.nav-links a').forEach(link => link.addEventListener('click', () => {
                navbar.classList.remove('menu-open');
                toggle.setAttribute('aria-expanded', 'false');
            }));
        })();
    </script>
</body>
</html>
