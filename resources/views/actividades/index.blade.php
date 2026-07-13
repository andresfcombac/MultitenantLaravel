@extends('layouts.app')

@section('title','Actividades')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

    <h2 class="fw-bold mb-0">

        <i class="fa-solid fa-calendar-days me-2"></i>

        Actividades

    </h2>

    <small class="text-muted">

        Administración de actividades registradas

    </small>

</div>

<a
    href="/actividades/create"
    class="btn btn-primary">

    <i class="fa-solid fa-plus me-2"></i>

    Nueva Actividad

</a>

</div>

<div class="card shadow-sm border-0">

<div class="card-body">

    <div class="table-responsive">

        <table
            id="tablaActividades"
            class="table table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th>Nombre</th>

                    <th>Fecha</th>

                    <th>Inicio</th>

                    <th>Fin</th>

                    <th>Empresa</th>

                    <th width="160">

                        Acciones

                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($actividades as $actividad)

                <tr>

                    <td>

                        <strong>

                            {{ $actividad->nombre_actividad }}

                        </strong>

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}

                    </td>

                    <td>

                        {{ $actividad->hora_inicio }}

                    </td>

                    <td>

                        {{ $actividad->hora_fin }}

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            {{ $actividad->empresa->nombre_empresa ?? 'Sin empresa' }}

                        </span>

                    </td>

                    <td>

                        <div class="d-flex gap-2">

                            <a
                                href="/actividades/{{ $actividad->id_actividad }}/edit"
                                class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form
    ...
    class="form-eliminar-actividad">

<button
    type="submit"
    class="btn btn-danger btn-sm"
    data-titulo="Eliminar actividad"
    data-mensaje="¿Desea eliminar esta actividad?">

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

document.querySelectorAll('.form-eliminar-actividad').forEach(function(form){

    form.addEventListener('submit',function(e){

        e.preventDefault();

        const boton=form.querySelector('button');

        Swal.fire({

            title: boton.dataset.titulo,

            text: boton.dataset.mensaje,

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
