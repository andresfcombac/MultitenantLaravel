@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<h2>Roles</h2>

<div class="mb-3">

    <a
        href="/roles/create"
        class="btn btn-primary">

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
                    class="btn btn-warning btn-sm">

                    Editar

                </a>

                <form
                    action="/roles/{{ $rol->id_rol }}/delete"
                    method="POST"
                    class="d-inline form-eliminar-rol">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-danger btn-sm"
                        data-titulo="Eliminar rol"
                        data-mensaje="¿Desea eliminar este rol?">

                        Eliminar

                    </button>

                </form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

@push('scripts')

<script>

document.querySelectorAll('.form-eliminar-rol').forEach(function(form){

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