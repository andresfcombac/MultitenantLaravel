<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="{{ asset('css/login.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="login-container">

    <div class="login-left">

    <div class="left-content">

        <div class="logo-circle">

    <img
        src="{{ asset('images/logo.png') }}"
        alt="Logo"
        class="logo-image">

</div>

        <h1>Multitenant</h1>

        <p class="system-description">

            Gestión de actividades, formularios y asistencia
            para múltiples empresas desde una sola plataforma.

        </p>

        <div class="company-list">

            <span class="company-badge">

                <i class="fa-solid fa-building"></i> Servientrega

            </span>

            <span class="company-badge">

                <i class="fa-solid fa-building"></i> Servitel

            </span>

            <span class="company-badge">

                <i class="fa-solid fa-building"></i> Global

            </span>

        </div>

        <div class="version-info">

            Versión 1.5

        </div>

    </div>

</div>

    <div class="login-right">

    <div class="login-card">

        <h2>

            Bienvenido

        </h2>

        <p class="login-subtitle">

            Ingresa tus credenciales para continuar

        </p>

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        <form
            method="POST"
            action="/login">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Correo electrónico

                </label>

                <input
                    type="email"
                    name="correo_usu"
                    class="form-control"
                    placeholder="correo@empresa.com"
                    required
                    autocomplete="username">

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Contraseña

                </label>

                <div class="input-group">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        id="togglePassword">

                        <i class="fa-solid fa-eye"></i>

                    </button>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-warning w-100">

                Ingresar

            </button>

        </form>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>

document
.getElementById('togglePassword')
.addEventListener('click',function(){

    const password =
        document.getElementById('password');

    const icon =
        this.querySelector('i');

    if(password.type === 'password'){

        password.type='text';

        icon.classList.remove('fa-eye');

        icon.classList.add('fa-eye-slash');

    }else{

        password.type='password';

        icon.classList.remove('fa-eye-slash');

        icon.classList.add('fa-eye');

    }

});

</script>

</body>

</html>