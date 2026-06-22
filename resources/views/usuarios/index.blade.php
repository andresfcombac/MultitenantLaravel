@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

<h2>Usuarios</h2>

<div class="mb-3">

    <a
        href="/usuarios/create"
        class="btn btn-primary"
    >
        Agregar Usuario
    </a>

</div>
<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Empresa</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

    @foreach($usuarios as $usuario)

        <tr>

            <td>
                {{ $usuario->id_usuario }}
            </td>

            <td>
                {{ $usuario->nombre_usu }}
                {{ $usuario->apellidos_usu }}
            </td>

            <td>
                {{ $usuario->correo_usu }}
            </td>

            <td>
                {{ $usuario->rol?->nombre_rol }}
            </td>

            <td>
                {{ $usuario->empresa?->nombre_empresa }}
            </td>

<td>

    <a
        href="/usuarios/{{ $usuario->id_usuario }}/edit"
        class="btn btn-warning btn-sm"
    >
        Editar
    </a>


    <form
        action="/usuarios/{{ $usuario->id_usuario }}/delete"
        method="POST"
        style="display:inline;"
    >

        @csrf

        <button
            type="submit"
            class="btn btn-danger btn-sm"
            onclick="return confirm('¿Eliminar usuario?')"
        >
            Eliminar
        </button>

    </form>

</td>

</td>

        </tr>

    @endforeach

    </tbody>

</table>

@endsection
