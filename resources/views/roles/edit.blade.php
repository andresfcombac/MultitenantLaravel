@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')

<h2>Editar Rol</h2>

<form
    method="POST"
    action="/roles/{{ $rol->id_rol }}/update"
>

    @csrf

    <div class="mb-3">

        <label>Nombre del Rol</label>

        <input
            type="text"
            name="nombre_rol"
            class="form-control"
            value="{{ $rol->nombre_rol }}"
            required
        >

    </div>

    <button
        type="submit"
        class="btn btn-success"
    >
        Actualizar
    </button>

    <a
        href="/roles"
        class="btn btn-secondary"
    >
        Volver
    </a>

</form>

@endsection
