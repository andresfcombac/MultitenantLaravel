@extends('layouts.app')

@section('title', $formulario->nombre_formulario)

@section('content')

<div class="container py-4">

    @if($formulario->descripcion)

        <div class="alert alert-light border mb-4">

            {{ $formulario->descripcion }}

        </div>

    @endif


<form method="POST" action="/formularios/{{ $formulario->id_formulario }}/responder">

    @csrf

    <div class="row">

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Nombres <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="nombres"
            class="form-control"
            required>

    </div>

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Apellidos <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="apellidos"
            class="form-control"
            required>

    </div>

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Correo <span class="text-danger">*</span>

        </label>

        <input
            type="email"
            name="correo"
            class="form-control"
            required>

    </div>

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Teléfono <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="telefono"
            class="form-control"
            required>

    </div>

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Tipo de documento <span class="text-danger">*</span>

        </label>

        <select
            name="tipo_documento"
            class="form-control"
            required>

            <option value="">Seleccione...</option>

            <option value="CC">Cédula de ciudadanía</option>

            <option value="TI">Tarjeta de identidad</option>

            <option value="CE">Cédula de extranjería</option>

            <option value="PA">Pasaporte</option>

            <option value="RC">Registro Civil</option>

            <option value="NIT">NIT</option>

        </select>

    </div>

    <div class="mb-3 col-md-6">

        <label class="form-label">

            Número de documento <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="numero_documento"
            class="form-control"
            required>

    </div>

</div>

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                {{ $formulario->nombre_formulario }}

            </h4>

        </div>

        <div class="card-body">

    <div class="row">
    @foreach($formulario->campos->sortBy('orden') as $campo)

        <div class="mb-3 col-md-6">

            <label class="form-label">
                {{ $campo->etiqueta }}

                @if($campo->obligatorio)
                    <span class="text-danger">*</span>
                @endif
            </label>

            @php
                $opciones = json_decode($campo->opciones, true) ?? [];
            @endphp


            {{-- TEXTO --}}
            @if($campo->tipo_campo == 'texto')

                <input
                    type="text"
                    name="{{ $campo->etiqueta }}"
                    class="form-control"
                    {{ $campo->obligatorio ? 'required' : '' }}
                >

            {{-- NUMERO --}}
            @elseif($campo->tipo_campo == 'numero')

                <input
                    type="number"
                    name="{{ $campo->etiqueta }}"
                    class="form-control"
                    {{ $campo->obligatorio ? 'required' : '' }}
                >

            {{-- FECHA --}}
            @elseif($campo->tipo_campo == 'fecha')

                <input
                    type="date"
                    name="{{ $campo->etiqueta }}"
                    class="form-control"
                    {{ $campo->obligatorio ? 'required' : '' }}
                >

            {{-- EMAIL --}}
            @elseif($campo->tipo_campo == 'email')

                <input
                    type="email"
                    name="{{ $campo->etiqueta }}"
                    class="form-control"
                    {{ $campo->obligatorio ? 'required' : '' }}
                >

            {{-- SELECT --}}
            @elseif($campo->tipo_campo == 'select')

                <select
                    name="{{ $campo->etiqueta }}"
                    class="form-control"
                    {{ $campo->obligatorio ? 'required' : '' }}
                >

                    <option value="">Seleccione...</option>

                    @foreach($opciones as $opcion)

                        <option value="{{ $opcion }}">
                            {{ $opcion }}
                        </option>

                    @endforeach

                </select>

            {{-- RADIO --}}
            @elseif($campo->tipo_campo == 'radio')

                @foreach($opciones as $opcion)

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="radio"
                            name="{{ $campo->etiqueta }}"
                            value="{{ $opcion }}"
                        >

                        <label class="form-check-label">
                            {{ $opcion }}
                        </label>

                    </div>
                    
                @endforeach

            {{-- CHECKBOX --}}
            @elseif($campo->tipo_campo == 'checkbox')

                @foreach($opciones as $opcion)

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="{{ $campo->etiqueta }}[]"
                            value="{{ $opcion }}"
                        >

                        <label class="form-check-label">
                            {{ $opcion }}
                        </label>

                    </div>

                @endforeach

            @endif

        </div>

    @endforeach


   <div class="mt-4">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-paper-plane me-2"></i>

        Enviar formulario

    </button>
    <a
    href="{{ url()->previous() }}"
    class="btn btn-secondary ms-2">

    <i class="fa-solid fa-arrow-left me-2"></i>

    Volver

</a>

</div>

        </div>

    </div>

</form>

</div>

@endsection