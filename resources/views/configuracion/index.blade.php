@extends('layouts.app')

@section('title','Configuración')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-gear me-2"></i>

            Configuración

        </h2>

        <small class="text-muted">

            Administración y configuración general del sistema.

        </small>

    </div>

</div>


<div class="row g-4">

    {{-- EMPRESA --}}

    @if(session('rol') == 5)

    <div class="col-md-6 col-xl-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-building fa-3x text-primary mb-3"></i>

                <h5>

                    Empresas

                </h5>

                <p class="text-muted">

                    Administración de empresas registradas.

                </p>

                <a
                    href="/empresas"
                    class="btn btn-primary">

                    Administrar

                </a>

            </div>

        </div>

    </div>

    @endif


    {{-- PERFIL --}}

<div class="col-md-6 col-xl-4">

    <div class="card shadow-sm border-0 h-100">

        <div class="card-body text-center">

            <i class="fa-solid fa-user fa-3x text-success mb-3"></i>

            <h5>
                Mi perfil
            </h5>

            <p class="text-muted">
                Información del usuario autenticado.
            </p>

            <a
                href="{{ route('perfil') }}"
                class="btn btn-success">

                Abrir perfil

            </a>

        </div>

    </div>

</div>


    {{-- ROLES --}}

    @if(session('rol') == 5)

    <div class="col-md-6 col-xl-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-user-shield fa-3x text-warning mb-3"></i>

                <h5>

                    Roles

                </h5>

                <p class="text-muted">

                    Administración de roles del sistema.

                </p>

                
                <a
    href="{{ route('perfil') }}"
    class="btn btn-success">

    Administrar

</a>


            </div>

        </div>

    </div>

    @endif

    

    {{-- SEGURIDAD --}}

<div class="col-md-6 col-xl-4">

    <div class="card shadow-sm border-0 h-100">

        <div class="card-body text-center">

            <i class="fa-solid fa-lock fa-3x text-danger mb-3"></i>

            <h5>
                Seguridad
            </h5>

            <p class="text-muted">
                Cambio de contraseña y políticas de acceso.
            </p>

            <a
                href="{{ route('perfil') }}"
                class="btn btn-danger">

                Gestionar contraseña

            </a>

        </div>

    </div>

</div>    

</div>


<div class="card shadow-sm border-0 mt-5">

    <div class="card-header bg-light">

        <strong>

            Información del usuario

        </strong>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <p>

                    <strong>Nombre:</strong>

                    {{ $usuario->nombre_usu }}

                </p>

                <p>

                    <strong>Correo:</strong>

                    {{ $usuario->correo_usu }}

                </p>

            </div>

            <div class="col-md-6">

                <p>

                    <strong>Rol:</strong>

                    {{ $usuario->rol->nombre_rol ?? '-' }}

                </p>

                <p>

                    <strong>Empresa:</strong>

                    {{ $usuario->empresa->nombre_empresa ?? 'Superadministrador' }}

                </p>

            </div>

        </div>

    </div>

</div>


<div class="card shadow-sm border-0 mt-4">

    <div class="card-header bg-light">

        <strong>

            Información del sistema

        </strong>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                <strong>Laravel</strong>

                <br>

                {{ app()->version() }}

            </div>

            <div class="col-md-3">

                <strong>PHP</strong>

                <br>

                {{ PHP_VERSION }}

            </div>

            <div class="col-md-3">

                <strong>Servidor</strong>

                <br>

                {{ request()->server('SERVER_SOFTWARE') }}

            </div>

            <div class="col-md-3">

                <strong>Fecha</strong>

                <br>

                {{ now()->format('d/m/Y H:i') }}

            </div>

        </div>

    </div>

</div>

@endsection