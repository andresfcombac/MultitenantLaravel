@extends('layouts.app')

@section('title','Histórico')

@section('content')

<div class="container">

    <h3>Histórico de asistencias</h3>

    <table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th>#</th>

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

                <td>

                    {{ $historico->id_asistencia }}

                </td>

                <td>

                    {{ $historico->respuesta->formulario->nombre_formulario ?? '-' }}

                </td>

                <td>

                    {{ $historico->respuesta->nombres }}
                    {{ $historico->respuesta->apellidos }}

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

                    {{ $historico->fecha_confirmacion }}

                </td>

                <td>

                    {{ $historico->usuario->nombre_usu ?? '-' }}

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8" class="text-center">

                    No existen registros históricos.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection