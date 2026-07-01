@extends('layouts.app')

@section('title','Asistencias')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">
            <i class="fa-solid fa-user-check me-2"></i>
            Asistencias
        </h2>

        <small class="text-muted">
            Confirmación de asistencia de participantes
        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table
                id="tablaAsistencias"
                class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Formulario</th>

                        <th>Participante</th>

                        <th>Correo</th>

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

                            {{ $respuesta->formulario->nombre_formulario ?? '' }}

                        </td>

                        <td>

                            <strong>

                                {{ $respuesta->nombres }}
                                {{ $respuesta->apellidos }}

                            </strong>

                        </td>

                        <td>

                            {{ $respuesta->correo }}

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
                            colspan="9"
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