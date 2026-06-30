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


<a href="/dashboard"
class="btn btn-outline-light btn-sm me-2">
Dashboard
</a>


@if(session('rol') == 5)

<a href="/empresas"
class="btn btn-outline-light btn-sm me-2">
Empresas
</a>

@endif

<a href="/usuarios"
class="btn btn-outline-light btn-sm me-2">
Usuarios
</a>

<a href="/formularios" class="btn btn-outline-light btn-sm me-2">
    Formularios
</a>
<a href="/actividades" class="btn btn-outline-light btn-sm me-2">
    Actividades
</a>
<a href="/asistencias"
class="btn btn-outline-light btn-sm me-2">
    Asistencias
</a>

<a href="/historico"
class="btn btn-outline-light btn-sm me-2">
    Histórico
</a>

</div>


<a href="/logout"
class="btn btn-danger btn-sm">
Cerrar sesión
</a>


</div>

</nav>


<div class="container mt-4">


@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>

@endif


@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>

@endif


@yield('content')


</div>


</body>
</html>
