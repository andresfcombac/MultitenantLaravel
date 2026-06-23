@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="card">

    <div class="card-header">
        Dashboard
    </div>


    <div class="card-body">


        <h3>
            Bienvenido {{ $usuario->nombre_usu }}
        </h3>


        <hr>


        <p>
            <strong>ID:</strong>
            {{ $usuario->id_usuario }}
        </p>


        <p>
            <strong>Correo:</strong>
            {{ $usuario->correo_usu }}
        </p>


        <p>
            <strong>Rol:</strong>
            {{ $usuario->rol?->nombre_rol ?? 'Sin rol' }}
        </p>


        @if(session('rol') == 5)

            <p>
                <strong>Acceso:</strong>
                Global (SuperAdmin)
            </p>


        @else

            <p>
                <strong>Empresa:</strong>
                {{ $usuario->empresa?->nombre_empresa ?? 'Sin empresa' }}
            </p>


        @endif


    </div>

</div>


@endsection