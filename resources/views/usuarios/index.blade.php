@extends('layouts.app')

@section('title','Usuarios')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <i class="fa-solid fa-users fa-2x text-primary"></i>
<small class="text-muted">Gestión de usuarios por empresa</small>

    </div>

    @if(in_array((int) session('rol'), [5, 3], true))
    <a href="/usuarios/create"
       class="btn btn-primary">

        <i class="fa-solid fa-plus me-2"></i>

        Nuevo Usuario

    </a>
    @endif

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table
                id="tablaUsuarios"
                class="table table-hover align-middle datatable">

                <thead class="table-light">

                <tr>

                    <th style="display:none;">ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Empresa</th>
                    <th width="170">Acciones</th>

                </tr>

                </thead>

                <tbody>

                @foreach($usuarios as $usuario)

                    <tr>

                        <td style="display:none;">{{ $usuario->id_usuario }}</td>

                        <td>

                            <strong>

                                {{ $usuario->nombre_usu }}

                                {{ $usuario->apellidos_usu }}

                            </strong>

                        </td>

                        <td>{{ $usuario->correo_usu }}</td>

                        <td>

                            @php

                                $color='secondary';

                                switch($usuario->rol?->nombre_rol){

                                    case 'SuperAdmin':
                                        $color='danger';
                                        break;

                                    case 'Administrador':
                                        $color='primary';
                                        break;

                                    case 'Usuario':
                                        $color='success';
                                        break;

                                }

                            @endphp

                            <span class="badge bg-{{ $color }}">
                                {{ $usuario->rol?->nombre_rol }}
                            </span>

                        </td>

                        <td>

                            {{ $usuario->empresa?->nombre_empresa }}

                        </td>

                        <td>

                            @php
                                $rolActual = (int) session('rol');
                                $rolObjetivo = (int) $usuario->rol_usu;
                                $puedeEditar = $rolActual === 5
                                    || ($rolActual === 3 && in_array($rolObjetivo, [1, 2], true))
                                    || ($rolActual === 1 && $rolObjetivo === 2);
                                $puedeEliminar = $rolActual === 5
                                    || ($rolActual === 3 && in_array($rolObjetivo, [1, 2], true));
                            @endphp

                            @if($puedeEditar)

                            <div class="d-flex gap-2">

                                <a
                                    href="/usuarios/{{ $usuario->id_usuario }}/edit"
                                    class="btn btn-sm btn-warning">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                @if($puedeEliminar)
                                <form
                                    action="/usuarios/{{ $usuario->id_usuario }}/delete"
                                    method="POST"
                                    class="form-eliminar-usuario">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        data-titulo="Eliminar usuario"
                                        data-mensaje="¿Desea eliminar este usuario?">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>
                                @endif

                            </div>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@push('scripts')

<script>

document.querySelectorAll('.form-eliminar-usuario').forEach(function(form){

    form.addEventListener('submit',function(e){

        e.preventDefault();

        const boton = form.querySelector('button');

        Swal.fire({

            title: boton.dataset.titulo,

            text: boton.dataset.mensaje,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Sí',

            cancelButtonText: 'Cancelar'

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush

@endsection
