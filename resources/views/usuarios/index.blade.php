@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

<h2>Usuarios</h2>

<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Empresa</th>
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

        </tr>

    @endforeach

    </tbody>

</table>

@endsection
