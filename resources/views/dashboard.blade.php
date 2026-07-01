@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<h2 class="mb-4">
    Bienvenido, {{ $usuario->nombre_usu }}
</h2>

<div class="row g-4">

```
@if(session('rol') == 5)
<div class="col-md-4 col-xl-3">

    <a href="/empresas" class="text-decoration-none">

        <div class="card dashboard-card bg-primary text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-building dashboard-icon"></i>

                <h6 class="mt-3">
                    Empresas
                </h6>

                <h2>
                    {{ $estadisticas['empresas'] }}
                </h2>

            </div>

        </div>

    </a>

</div>
@endif

<div class="col-md-4 col-xl-3">

    <a href="/usuarios" class="text-decoration-none">

        <div class="card dashboard-card bg-success text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-users dashboard-icon"></i>

                <h6 class="mt-3">
                    Usuarios
                </h6>

                <h2>
                    {{ $estadisticas['usuarios'] }}
                </h2>

            </div>

        </div>

    </a>

</div>

<div class="col-md-4 col-xl-3">

    <a href="/formularios" class="text-decoration-none">

        <div class="card dashboard-card bg-warning text-dark border-0">

            <div class="card-body">

                <i class="fa-solid fa-file-lines dashboard-icon"></i>

                <h6 class="mt-3">
                    Formularios
                </h6>

                <h2>
                    {{ $estadisticas['formularios'] }}
                </h2>

            </div>

        </div>

    </a>

</div>

<div class="col-md-4 col-xl-3">

    <a href="/actividades" class="text-decoration-none">

        <div class="card dashboard-card bg-info text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-calendar-days dashboard-icon"></i>

                <h6 class="mt-3">
                    Actividades
                </h6>

                <h2>
                    {{ $estadisticas['actividades'] }}
                </h2>

            </div>

        </div>

    </a>

</div>

<div class="col-md-4 col-xl-3">

    <a href="#" class="text-decoration-none">

        <div class="card dashboard-card bg-secondary text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-list-check dashboard-icon"></i>

                <h6 class="mt-3">
                    Respuestas
                </h6>

                <h2>
                    {{ $estadisticas['respuestas'] }}
                </h2>

            </div>

        </div>

    </a>

</div>

<div class="col-md-4 col-xl-3">

    <a href="/asistencias" class="text-decoration-none">

        <div class="card dashboard-card bg-danger text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-user-check dashboard-icon"></i>

                <h6 class="mt-3">
                    Asistencias
                </h6>

                <h2>
                    {{ $estadisticas['asistencias'] }}
                </h2>

            </div>

        </div>

    </a>

</div>

<div class="col-md-4 col-xl-3">

    <a href="/historico" class="text-decoration-none">

        <div class="card dashboard-card bg-dark text-white border-0">

            <div class="card-body">

                <i class="fa-solid fa-clock-rotate-left dashboard-icon"></i>

                <h6 class="mt-3">
                    Histórico
                </h6>

                <h2>
                    {{ $estadisticas['historico'] }}
                </h2>

            </div>

        </div>

    </a>

</div>
```

</div>

<div class="card mt-5 shadow-sm border-0">

```
<div class="card-body">

    <h5>
        Información del usuario
    </h5>

    <hr>

    <p>
        <strong>Correo:</strong>
        {{ $usuario->correo_usu }}
    </p>

    <p>
        <strong>Rol:</strong>
        {{ $usuario->rol?->nombre_rol }}
    </p>

    @if(session('rol') != 5)

    <p>
        <strong>Empresa:</strong>
        {{ $usuario->empresa?->nombre_empresa }}
    </p>

    @endif

</div>
```

</div>

@endsection
