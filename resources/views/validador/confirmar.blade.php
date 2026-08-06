@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h4 class="mb-0">

                        Confirmación de ingreso

                    </h4>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th>Nombre</th>
                            <td>{{ $respuesta->nombres }} {{ $respuesta->apellidos }}</td>
                        </tr>

                        <tr>
                            <th>Documento</th>
                            <td>{{ $respuesta->tipo_documento }} {{ $respuesta->numero_documento }}</td>
                        </tr>

                        <tr>
                            <th>Correo</th>
                            <td>{{ $respuesta->correo }}</td>
                        </tr>

                        <tr>
                            <th>Fecha registro</th>
                            <td>{{ $respuesta->fecha_respuesta }}</td>
                        </tr>

                    </table>

                    <div class="text-center">

                        <form
                            method="POST"
                            action="{{ route('validador.confirmar') }}">

                            @csrf

                            <input
                                type="hidden"
                                name="codigo"
                                value="{{ $respuesta->id_respuesta }}">

                            <button
                                class="btn btn-success btn-lg">

                                Confirmar ingreso

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection