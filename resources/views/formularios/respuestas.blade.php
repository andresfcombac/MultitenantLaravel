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

    <div>

        <a href="/formularios/{{ $formulario->id_formulario }}/exportar"
           class="btn btn-success">

            <i class="fa-solid fa-file-csv me-2"></i>

            Exportar CSV

        </a>

        <a href="/formularios"
           class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Volver

        </a>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

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

                        <th>Datos</th>

                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($respuestas as $respuesta)

                        <tr>

                            <td>

                                {{ $respuesta->nombres }}

                            </td>

                            <td>

                                {{ $respuesta->apellidos }}

                            </td>

                            <td>

                                {{ $respuesta->correo }}

                            </td>

                            <td>

                                {{ $respuesta->telefono }}

                            </td>

                            <td>

                                {{ $respuesta->tipo_documento }}

                                <br>

                                {{ $respuesta->numero_documento }}

                            </td>

                            <td>

                                @foreach($respuesta->datos as $campo => $valor)

                                    <strong>

                                        {{ $campo }}

                                    </strong>

                                    :

                                    {{ $valor }}

                                    <br>

                                @endforeach

                            </td>

                            <td>

                                {{ $respuesta->fecha_respuesta }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection