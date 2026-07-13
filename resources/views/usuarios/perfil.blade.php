@extends('layouts.app')

@section('title','Mi Perfil')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <form method="POST" action="{{ route('perfil.actualizar') }}">

                @csrf

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h4 class="mb-0">
                            <i class="fa-solid fa-user me-2"></i>
                            Mi Perfil
                        </h4>

                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre_usu"
                                    class="form-control"
                                    value="{{ old('nombre_usu', $usuario->nombre_usu) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Apellidos
                                </label>

                                <input
                                    type="text"
                                    name="apellidos_usu"
                                    class="form-control"
                                    value="{{ old('apellidos_usu', $usuario->apellidos_usu) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Correo
                                </label>

                                <input
                                    type="email"
                                    name="correo_usu"
                                    class="form-control"
                                    value="{{ old('correo_usu', $usuario->correo_usu) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    name="telefono_usu"
                                    class="form-control"
                                    value="{{ old('telefono_usu', $usuario->telefono_usu) }}">

                            </div>
                             <hr class="my-4">

<h5 class="mb-3">
    <i class="fa-solid fa-key me-2"></i>
    Cambiar contraseña
</h5>

<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">
            Contraseña actual
        </label>

        <input
            type="password"
            name="password_actual"
            class="form-control">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">
            Nueva contraseña
        </label>

        <input
            type="password"
            name="password"
            class="form-control">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">
            Confirmar contraseña
        </label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control">

    </div>

</div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Rol
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $usuario->rol->nombre_rol ?? '' }}"
                                    readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Empresa
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $usuario->empresa->nombre_empresa ?? '' }}"
                                    readonly>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-white text-end">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fa-solid fa-floppy-disk me-2"></i>

                            Guardar cambios

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection