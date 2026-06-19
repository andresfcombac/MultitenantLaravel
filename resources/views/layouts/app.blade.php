<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Multitenant Laravel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">

        <div>

            <span class="navbar-brand">
                Multitenant Laravel
            </span>

            <a href="/dashboard" class="btn btn-outline-light btn-sm me-2">
                Dashboard
            </a>

            <a href="/empresas" class="btn btn-outline-light btn-sm me-2">
                Empresas
            </a>

        </div>

        <a href="/logout" class="btn btn-danger btn-sm">
            Cerrar sesión
        </a>

    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
