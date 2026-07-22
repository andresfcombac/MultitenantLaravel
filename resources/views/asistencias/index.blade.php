@extends('layouts.app')

@section('title','Asistencias')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <i class="fa-solid fa-user-check fa-2x text-primary"></i>
<small class="text-muted">Control de asistencia y registros</small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">
            <style>
#tablaAsistencias{
    width:100% !important;
    table-layout:auto;
}

#tablaAsistencias thead th{
    color:#212529 !important;
    background:#f8f9fa !important;
    font-weight:600;
    white-space:nowrap;
    vertical-align:middle;
}

/* Anchos mínimos por columna */
#tablaAsistencias th:nth-child(2),
#tablaAsistencias td:nth-child(2){ min-width:140px; } /* Empresa */

#tablaAsistencias th:nth-child(3),
#tablaAsistencias td:nth-child(3){ min-width:220px; } /* Actividad */

#tablaAsistencias th:nth-child(4),
#tablaAsistencias td:nth-child(4){ min-width:140px; } /* Formulario */

#tablaAsistencias th:nth-child(5),
#tablaAsistencias td:nth-child(5){ min-width:180px; } /* Participante */

#tablaAsistencias th:nth-child(6),
#tablaAsistencias td:nth-child(6){ min-width:150px; } /* Documento */

#tablaAsistencias th:nth-child(7),
#tablaAsistencias td:nth-child(7){ min-width:260px; } /* Correo */

#tablaAsistencias th:nth-child(8),
#tablaAsistencias td:nth-child(8){ min-width:140px; } /* Teléfono */

#tablaAsistencias th:nth-child(9),
#tablaAsistencias td:nth-child(9){ min-width:170px; } /* Fecha respuesta */

#tablaAsistencias th:nth-child(10),
#tablaAsistencias td:nth-child(10){ min-width:120px; } /* Estado */

#tablaAsistencias th:nth-child(11),
#tablaAsistencias td:nth-child(11){ min-width:150px; } /* Acción */

#tablaAsistencias th:nth-child(12),
#tablaAsistencias td:nth-child(12){ min-width:160px; } /* Confirmado por */

#tablaAsistencias th:nth-child(13),
#tablaAsistencias td:nth-child(13){ min-width:180px; } /* Fecha confirmación */

#tablaAsistencias td{
    vertical-align:middle;
}
</style>

            <table
    id="tablaAsistencias"
    class="table table-hover align-middle datatable">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

<th>Empresa</th>

<th>Actividad</th>

<th>Formulario</th>

<th>Participante</th>

<th>Documento</th>

<th>Correo</th>

<th>Teléfono</th>

<th>Fecha respuesta</th>

<th>Estado</th>

<th>Acción</th>

<th>Confirmado por</th>

<th>Fecha confirmación</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($respuestas as $respuesta)

                    <tr>

                        <td>

                            {{ $respuesta->id_respuesta }}

                        </td>

                        <td>
    {{ $respuesta->formulario->actividad->empresa->nombre_empresa ?? '-' }}
</td>

<td>
    {{ $respuesta->formulario->actividad->nombre_actividad ?? '-' }}
</td>

<td>
    {{ $respuesta->formulario->nombre_formulario ?? '-' }}
</td>

<td>
    <strong>
        {{ $respuesta->nombres }}
        {{ $respuesta->apellidos }}
    </strong>
</td>

<td>
    {{ $respuesta->tipo_documento }}
    <br>
    {{ $respuesta->numero_documento }}
</td>

<td>
    {{ $respuesta->correo }}
</td>

<td>
    {{ $respuesta->telefono }}
</td>

<td>
    {{ $respuesta->fecha_respuesta }}
</td>

                        <td>

                            @if($respuesta->asistencia)

                                <span class="badge bg-success">

                                    Confirmada

                                </span>

                            @else

                                <span class="badge bg-warning text-dark">

                                    Pendiente

                                </span>

                            @endif

                        </td>

                        <td>

                            @if(!$respuesta->asistencia)

                                <form
                                    method="POST"
                                    action="/asistencias/{{ $respuesta->id_respuesta }}/confirmar">

                                    @csrf

                                    <button
                                        class="btn btn-success btn-sm">

                                        <i class="fa-solid fa-check me-1"></i>

                                        Confirmar

                                    </button>

                                </form>

                            @else

                                <button
                                    class="btn btn-secondary btn-sm"
                                    disabled>

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Confirmada

                                </button>

                            @endif

                        </td>

                        <td>

                            {{ $respuesta->asistencia->usuario->nombre_usu ?? '-' }}

                        </td>

                        <td>

                            {{ $respuesta->asistencia->fecha_confirmacion ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="13"
                            class="text-center">

                            No existen respuestas registradas.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection