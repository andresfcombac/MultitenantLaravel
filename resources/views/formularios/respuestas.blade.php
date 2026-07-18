@extends('layouts.app')

@section('title','Respuestas del formulario')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">
            <i class="fa-solid fa-file-lines me-2"></i>
            {{ $formulario->nombre_formulario }}
        </h2>

        <small class="text-muted">
            Respuestas registradas del formulario
        </small>

    </div>

    <div class="d-flex align-items-center gap-2">

        <a
            href="/formularios/{{ $formulario->id_formulario }}/exportar"
            class="btn btn-primary" title="Exportar respuestas en formato CSV">

            <i class="fa-solid fa-file-csv me-2"></i>
            

        </a>

        <a
            href="{{ route('formularios.respuestas.exportar', $formulario->id_formulario) }}"
            class="btn btn-success"  title="Exportar respuestas en formato Excel">

            <i class="fa-solid fa-file-excel me-2"></i>
            

        </a>

        <form
            action="{{ route('formularios.importar', $formulario->id_formulario) }}"
            method="POST"
            enctype="multipart/form-data"
            class="d-flex align-items-center gap-2 mb-0">

            @csrf

            <input
    type="file"
    name="archivo"
    class="form-control"
    style="width:220px"
    title="Seleccione el archivo Excel (.xlsx) que desea importar"
    required>

            <button
                type="submit"
                class="btn btn-warning" title="Importar respuestas desde un archivo Excel">

                <i class="fa-solid fa-file-import me-2"></i>
                

            </button>

        </form>

        <a
    href="/formularios"
    class="btn btn-secondary"
    title="Regresar al listado de formularios">

    <i class="fa-solid fa-arrow-left me-2"></i>
    

</a>

    </div>

</div>

<div class="card mt-3 mb-3">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-3">

                    <input
                        type="text"
                        name="nombre"
                        value="{{ request('nombre') }}"
                        class="form-control"
                        placeholder="Buscar por nombre">

                </div>

                <div class="col-md-3">

                    <input
                        type="text"
                        name="correo"
                        value="{{ request('correo') }}"
                        class="form-control"
                        placeholder="Buscar por correo">

                </div>

                <div class="col-md-3">

                    <input
                        type="text"
                        name="documento"
                        value="{{ request('documento') }}"
                        class="form-control"
                        placeholder="Número documento">

                </div>

                <div class="col-md-3">

                    <button class="btn btn-primary"
                    title="Buscar">

                        <i class="fa fa-search me-2"></i>
                       
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-4">

                <div class="card border-primary shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Total respuestas

                        </h6>

                        <h2 class="fw-bold text-primary">

                            {{ $totalRespuestas }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-success shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Respuestas hoy

                        </h6>

                        <h2 class="fw-bold text-success">

                            {{ $respuestasHoy }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-warning shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Respuestas este mes

                        </h6>

                        <h2 class="fw-bold text-warning">

                            {{ $respuestasMes }}

                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <div class="table-responsive">

<style>
#tablaRespuestas thead th{
    color:#212529 !important;
    background:#f8f9fa !important;
    font-weight:600;
}
</style>

<table
    id="tablaRespuestas"
    class="table table-hover align-middle">

    <thead class="table-light">

        <tr>

            <th>Nombres</th>

            <th>Apellidos</th>

            <th>Correo</th>

            <th>Teléfono</th>

            <th>Documento</th>

            @foreach($formulario->campos->sortBy('orden') as $campo)

                <th>{{ $campo->etiqueta }}</th>

            @endforeach

            <th>Fecha</th>

        </tr>

    </thead>

    <tbody>

        @foreach($respuestas as $respuesta)

            <tr>

                <td>{{ $respuesta->nombres }}</td>

                <td>{{ $respuesta->apellidos }}</td>

                <td>{{ $respuesta->correo }}</td>

                <td>{{ $respuesta->telefono }}</td>

                <td>

                    {{ $respuesta->tipo_documento }}

                    <br>

                    {{ $respuesta->numero_documento }}

                </td>
                                @foreach($formulario->campos->sortBy('orden') as $campo)

                    <td>

                        {{ $respuesta->datos[$campo->etiqueta] ?? '' }}

                    </td>

                @endforeach

                <td>

                    {{ $respuesta->fecha_respuesta }}

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

<div class="mt-3">

    {{ $respuestas->links() }}

</div>

        </div>

    </div>

</div>

@endsection