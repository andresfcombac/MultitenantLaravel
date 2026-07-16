@extends('layouts.app')

@section('title','Histórico')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-clock-rotate-left me-2"></i>

            Histórico

        </h2>

        <small class="text-muted">

            Historial de confirmaciones de asistencia

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table
                id="tablaHistorico"
                class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th style="display:none;">ID</th>

                        <th>Formulario</th>

                        <th>Participante</th>

                        <th>Correo</th>

                        <th>Documento</th>

                        <th>Fecha respuesta</th>

                        <th>Fecha confirmación</th>

                        <th>Confirmado por</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($historicos as $historico)

                    <tr>

                        <td style="display:none;">

                            {{ $historico->id_asistencia }}

                        </td>

                        <td>

                            {{ $historico->respuesta->formulario->nombre_formulario ?? '-' }}

                        </td>

                        <td>

                            <strong>

                                {{ $historico->respuesta->nombres }}

                                {{ $historico->respuesta->apellidos }}

                            </strong>

                        </td>

                        <td>

                            {{ $historico->respuesta->correo }}

                        </td>

                        <td>

                            {{ $historico->respuesta->tipo_documento }}

                            -

                            {{ $historico->respuesta->numero_documento }}

                        </td>

                        <td>

                            {{ $historico->respuesta->fecha_respuesta }}

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ $historico->fecha_confirmacion }}

                            </span>

                        </td>

                        <td>

                            {{ $historico->usuario->nombre_usu ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center">

                            No existen registros históricos.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


@endsection