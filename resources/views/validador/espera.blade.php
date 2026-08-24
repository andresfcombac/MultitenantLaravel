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

                    <p class="mb-3">
                        El código es válido y está pendiente de validación.
                    </p>

                    <div class="alert alert-info">

                        Espere al personal autorizado para confirmar su ingreso.
                        Por seguridad, los datos personales solo se muestran al personal autorizado.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
