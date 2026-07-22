<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Ingresar · CTPRGV</title><link rel="stylesheet" href="{{ asset('css/admin.css') }}"></head>
<body class="login-page">
<main class="login-card">
    <div class="login-brand"><img src="{{ asset('images/escudo.png') }}" alt="Escudo"><h1>Administración</h1><p class="muted">CTP Roberto Gamboa Valverde</p></div>
    @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field"><label for="email">Correo electrónico</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
        <div class="field"><label for="password">Contraseña</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
        <div class="field"><label><input name="remember" type="checkbox" value="1"> Mantener sesión iniciada</label></div>
        <button class="button" type="submit">Ingresar al panel</button>
    </form>
</main>
</body>
</html>
