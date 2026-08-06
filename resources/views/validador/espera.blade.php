@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-warning">

                    <h4 class="mb-0">

                        Registro encontrado

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
                            <th>Estado</th>
                            <td>
                                Pendiente de validación
                            </td>
                        </tr>

                    </table>

                    <div class="alert alert-info">

                        Espere al personal autorizado para confirmar su ingreso.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection