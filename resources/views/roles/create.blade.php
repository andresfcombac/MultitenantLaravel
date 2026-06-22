@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')

<h2>Crear Rol</h2>

<form method="POST" action="/roles/store">

    @csrf

    <div class="mb-3">

        <label>Nombre del Rol</label>

        <input
            type="text"
            name="nombre_rol"
            class="form-control"
            required
        >

    </div>

    <button
        type="submit"
        class="btn btn-success"
    >
        Guardar
    </button>

    <a
        href="/roles"
        class="btn btn-secondary"
    >
        Volver
    </a>

</form>

@endsection

