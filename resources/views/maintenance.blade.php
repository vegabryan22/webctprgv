<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $title }} - CTP Roberto Gamboa Valverde</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ config('version.number') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="maintenance-page">
    <main class="maintenance-screen">
        <section class="maintenance-screen__card">
            <img src="{{ asset('images/escudo.png') }}" alt="Escudo del CTP Roberto Gamboa Valverde">
            <span><i class="fas fa-person-digging"></i> Sitio en revisión</span>
            <h1>{{ $title }}</h1>
            <p>{{ $message }}</p>
            <div class="maintenance-screen__divider"></div>
            <p class="maintenance-screen__review">Si cuenta con acceso de revisión, inicie sesión para consultar el sitio completo.</p>
            <a href="{{ route('login', ['redirect' => $returnTo]) }}"><i class="fas fa-right-to-bracket"></i> Iniciar sesión como revisor</a>
        </section>
    </main>
</body>
</html>
