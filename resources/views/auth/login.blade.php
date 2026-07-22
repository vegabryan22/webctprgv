<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Ingresar · CTPRGV</title><link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ config('version.number') }}"></head>
<body class="login-page">
<main class="login-card">
    <div class="login-brand"><img src="{{ asset('images/escudo.png') }}" alt="Escudo"><h1>Administración</h1><p class="muted">CTP Roberto Gamboa Valverde</p></div>
    @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field"><label for="email">Correo electrónico</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
        <div class="field"><label for="password">Contraseña</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
        <label class="login-remember"><input name="remember" type="checkbox" value="1"><span>Mantener sesión iniciada</span></label>
        <button class="button login-submit" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Ingresar al panel</button>
    </form>
    <a class="login-back" href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Volver al sitio</a>
</main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</body>
</html>
