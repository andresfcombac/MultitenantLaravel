@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

<div class="d-flex align-items-center mb-4">

    <div>

        <small class="text-muted">

            <i class="fa-solid fa-user-pen me-2 text-primary"></i>

            Actualización de la información del usuario

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

<form
    method="POST"
    action="/usuarios/{{ $usuario->id_usuario }}/update"
>

    @csrf

    <div class="mb-3">
        <label>Nombres</label>
        <input
            type="text"
            name="nombre_usu"
            class="form-control"
            value="{{ $usuario->nombre_usu }}"
        >
    </div>

    <div class="mb-3">
        <label>Apellidos</label>
        <input
            type="text"
            name="apellidos_usu"
            class="form-control"
            value="{{ $usuario->apellidos_usu }}"
        >
    </div>

    <div class="mb-3">
        <label>Correo</label>
        <input
            type="email"
            name="correo_usu"
            class="form-control"
            value="{{ $usuario->correo_usu }}"
        >
    </div>

    <div class="mb-3">
        <label>Teléfono</label>
        <input
            type="text"
            name="telefono_usu"
            class="form-control"
            value="{{ $usuario->telefono_usu }}"
        >
    </div>

    <div class="mb-3">
        <label>Cargo</label>
        <input
            type="text"
            name="cargo"
            class="form-control"
            value="{{ $usuario->cargo }}"
        >
    </div>

    <div class="mb-3">
        <label>Rol</label>

        <select
            name="rol_usu"
            class="form-control"
        >

            @foreach($roles as $rol)

                <option
                    value="{{ $rol->id_rol }}"
                    {{ $usuario->rol_usu == $rol->id_rol ? 'selected' : '' }}
                >
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
    >

        @foreach($empresas as $empresa)

            <option
                value="{{ $empresa->id_empresa }}"
                {{ $usuario->empresa_usu == $empresa->id_empresa ? 'selected' : '' }}
            >
                {{ $empresa->nombre_empresa }}
            </option>

        @endforeach

    </select>

@else

    <input
        type="text"
        class="form-control"
        value="{{ $usuario->empresa?->nombre_empresa }}"
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

        Actualizar

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
