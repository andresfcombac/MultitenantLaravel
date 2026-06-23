@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<div class="card">

    <div class="card-header">
        <h3>Crear Usuario</h3>
    </div>

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

            <button
                type="submit"
                class="btn btn-success"
            >
                Guardar
            </button>

            <a
                href="/usuarios"
                class="btn btn-secondary"
            >
                Volver
            </a>

        </form>

    </div>

</div>

@endsection
