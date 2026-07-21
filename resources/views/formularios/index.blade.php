@extends('layouts.app')

@section('title','Formularios')

@section('content')

@php
    $rolNombreFormularios = \App\Models\Role::find(session('rol'))->nombre_rol ?? null;
    $menuAdministracion = in_array($rolNombreFormularios, ['SuperAdmin','Administrador']);
    $puedeVerRespuestas = in_array($rolNombreFormularios, ['SuperAdmin','Administrador','Supervisor']);
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">


<div>

    <h2 class="fw-bold mb-0">

        <i class="fa-solid fa-file-lines me-2"></i>

        Formularios

    </h2>

    <small class="text-muted">

        Administración de formularios del sistema

    </small>

</div>

@if($menuAdministracion)

<a
    href="/formularios/create"
    class="btn btn-primary">

    <i class="fa-solid fa-plus me-2"></i>

    Nuevo Formulario

</a>

@endif


</div>

<div class="card shadow-sm border-0">


<div class="card-body">

    <div class="table-responsive">

        <table
            id="tablaFormularios"
            class="table table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th>Formulario</th>

                    <th>Actividad</th>

                    <th>Estado</th>

                    <th width="330">

                        Acciones

                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($formularios as $formulario)

                <tr>

                    <td>

                        <strong>

                            {{ $formulario->nombre_formulario }}

                        </strong>

                    </td>

                    <td>

                        {{ $formulario->actividad->nombre_actividad ?? 'Sin actividad' }}

                    </td>

                    <td>

                        @if($formulario->estado==1)

                            <span class="badge bg-success">

                                Activo

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactivo

                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="d-flex flex-wrap gap-2">

                            <a
                                href="/formularios/{{ $formulario->id_formulario }}"
                                class="btn btn-secondary btn-sm"
                                title="Responder">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            @if($puedeVerRespuestas)

                                                        <a
                                href="/formularios/{{ $formulario->id_formulario }}/respuestas"
                                class="btn btn-info btn-sm"
                                title="Respuestas">

                                <i class="fa-solid fa-inbox"></i>

                            </a>

                            @endif

                            @if($menuAdministracion)

                            <a
                                href="/formularios/{{ $formulario->id_formulario }}/edit"
                                class="btn btn-warning btn-sm"
                                title="Editar">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form
    action="/formularios/{{ $formulario->id_formulario }}/estado"
    method="POST"
    class="form-cambiar-estado">

    @csrf

    @if($formulario->estado==1)

        <button
            type="submit"
            class="btn btn-danger btn-sm"
            data-mensaje="¿Desea desactivar este formulario?"
            data-titulo="Desactivar formulario"
            title="Desactivar">

            <i class="fa-solid fa-ban"></i>

        </button>

    @else

        <button
            type="submit"
            class="btn btn-success btn-sm"
            data-mensaje="¿Desea activar este formulario?"
            data-titulo="Activar formulario"
            title="Activar">

            <i class="fa-solid fa-check"></i>

        </button>

    @endif

</form>

                            @endif

                        </div>

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

document.querySelectorAll('.form-cambiar-estado').forEach(function(form){

    form.addEventListener('submit',function(e){

        e.preventDefault();

        const boton=form.querySelector('button');

        Swal.fire({

            title:boton.dataset.titulo,

            text:boton.dataset.mensaje,

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#dc3545',

            cancelButtonColor:'#6c757d',

            confirmButtonText:'Sí',

            cancelButtonText:'Cancelar'

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

