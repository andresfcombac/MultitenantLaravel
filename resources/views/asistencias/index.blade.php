@extends('layouts.app')

@section('title','Asistencias')

@section('content')

<div class="container">

    <h3>Asistencias</h3>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if(session('warning'))

        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>

    @endif

    <table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th>#</th>

                <th>Formulario</th>

                <th>Nombre</th>

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

                    {{ $respuesta->nombres }}
                    {{ $respuesta->apellidos }}

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
                            action="/asistencias/{{ $respuesta->id_respuesta }}/confirmar"
                            style="display:inline;">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success btn-sm">

                                Confirmar

                            </button>

                        </form>

                    @else

                        <button
                            class="btn btn-secondary btn-sm"
                            disabled>

                            Confirmada

                        </button>

                    @endif

                </td>

                <td>

                    @if($respuesta->asistencia)

                        {{ $respuesta->asistencia->usuario->nombre_usu ?? '-' }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    @if($respuesta->asistencia)

                        {{ $respuesta->asistencia->fecha_confirmacion }}

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="9" class="text-center">

                    No existen respuestas registradas.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection