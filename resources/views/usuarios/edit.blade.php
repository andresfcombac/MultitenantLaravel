@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

<h2>Editar Usuario</h2>

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

    <button
        type="submit"
        class="btn btn-success"
    >
        Actualizar
    </button>

    <a
        href="/usuarios"
        class="btn btn-secondary"
    >
        Volver
    </a>

</form>

@endsection
