@extends('layouts.app')

@section('title', 'Ingreso confirmado')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    <h4 class="mb-0">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        Ingreso confirmado
                    </h4>

                </div>

                <div class="card-body text-center">

                    <div class="mb-4">

                        <i
                            class="fa-solid fa-circle-check text-success"
                            style="font-size:70px;">
                        </i>

                    </div>

                    <h3 class="text-success">
                        Asistencia confirmada
                    </h3>

                    <p class="mt-3">

                        La asistencia de

                        <strong>
                            {{ $respuesta->nombres }}
                            {{ $respuesta->apellidos }}
                        </strong>

                        ya fue confirmada.

                    </p>

                    <p class="text-muted">
                        Este registro ya fue validado y no requiere
                        una nueva confirmación.
                    </p>

                    <a
                        href="{{ url('/validador') }}"
                        class="btn btn-primary mt-3">

                        <i class="fa-solid fa-qrcode me-2"></i>

                        Volver al validador

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
