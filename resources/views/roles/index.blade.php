@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<h2>Roles</h2>

<div class="mb-3">

    <a
        href="/roles/create"
        class="btn btn-primary"
    >
        Agregar Rol
    </a>

</div>

<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Rol</th>
            <th>Cantidad Usuarios</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

    @foreach($roles as $rol)

        <tr>

            <td>
                {{ $rol->id_rol }}
            </td>

            <td>
                {{ $rol->nombre_rol }}
            </td>

            <td>
                {{ $rol->usuarios_count }}
            </td>
            <td>

    <a
        href="/roles/{{ $rol->id_rol }}/edit"
        class="btn btn-warning btn-sm"
    >
        Editar
    </a>

</td>

        </tr>

    @endforeach

    </tbody>

</table>

@endsection
