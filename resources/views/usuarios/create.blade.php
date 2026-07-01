@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<div class="card">

    <div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-user-plus me-2"></i>

            Crear Usuario

        </h2>

        <small class="text-muted">

            Registro de un nuevo usuario del sistema

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <form method="POST" action="/usuarios/store">

            @csrf

            <div class="mb-3">
                <label>Nombres</label>
                <input
                    type="text"
                    name="nombre_usu"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Apellidos</label>
                <input
                    type="text"
                    name="apellidos_usu"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Correo</label>
                <input
                    type="email"
                    name="correo_usu"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Rol</label>

                <select
                    name="rol_usu"
                    class="form-control"
                    required
                >

                    @foreach($roles as $rol)

                        <option value="{{ $rol->id_rol }}">
                            {{ $rol->nombre_rol }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">
    
<label>Empresa</label>

@if(session('rol') == 5)

    <select
        name="empresa_usu"
        class="form-control"
        required
    >

        @foreach(\App\Models\Empresa::all() as $empresa)

            <option value="{{ $empresa->id_empresa }}">
                {{ $empresa->nombre_empresa }}
            </option>

        @endforeach

    </select>

@else

    <input
        type="text"
        class="form-control"
        value="{{ $empresa->nombre_empresa }}"
        readonly
    >

@endif


</div>


</div>

            <div class="d-flex gap-2">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Guardar

    </button>

    <a
        href="/usuarios"
        class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Volver

    </a>

</div>

        </form>

    </div>

</div>

@endsection
