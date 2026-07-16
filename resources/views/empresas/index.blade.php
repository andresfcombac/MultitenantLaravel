@extends('layouts.app')

@section('title','Empresas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-building me-2"></i>

            Empresas

        </h2>

        <small class="text-muted">

            Administración de empresas registradas

        </small>

    </div>

    <a
        href="/empresas/create"
        class="btn btn-primary">

        <i class="fa-solid fa-plus me-2"></i>

        Nueva Empresa

    </a>

</div>


<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table
                id="tablaEmpresas"
                class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th style="display:none;">ID</th>

                        <th>Empresa</th>

                        <th>URL</th>

                        <th width="150">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($empresas as $empresa)

                    <tr>

                        <td style="display:none;">

                            {{ $empresa->id_empresa }}

                        </td>

                        <td>

                            <strong>

                                {{ $empresa->nombre_empresa }}

                            </strong>

                        </td>

                        <td>

                            @if($empresa->url)

                                <span class="badge bg-info">

                                    {{ $empresa->url }}

                                </span>

                            @else

                                <span class="text-muted">

                                    Sin URL

                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="/empresas/{{ $empresa->id_empresa }}/edit"
                                    class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <form
    action="/empresas/{{ $empresa->id_empresa }}/delete"
    method="POST"
    class="form-eliminar-empresa">

    @csrf

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        data-titulo="Eliminar empresa"
        data-mensaje="¿Desea eliminar esta empresa?">

        <i class="fa-solid fa-trash"></i>

    </button>

</form>
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

document.querySelectorAll('.form-eliminar-empresa').forEach(function(form){

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

            confirmButtonText:'Eliminar',

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

