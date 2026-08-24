@extends('layouts.app')

@section('title','Formulario')

@section('content')

<div class="container">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h3 class="fw-bold">
                {{ $formulario->nombre_formulario }}
            </h3>

            <p class="text-muted">
                {{ $formulario->descripcion }}
            </p>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <form
                method="POST"
                action="/formulario/{{ $formulario->id_formulario }}/respuesta">

                @csrf

                @php
                    // Precarga los datos del usuario si tiene sesión activa;
                    // old() mantiene lo digitado si la validación falla.
                    $tipoDoc = old('tipo_documento', $usuario->tipo_doc_usu ?? '');
                @endphp

                <h5 class="border-bottom pb-2 mb-3">
                    Datos personales
                </h5>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nombres
                    </label>

                    <input
                        type="text"
                        name="nombres"
                        class="form-control"
                        value="{{ old('nombres', $usuario->nombre_usu ?? '') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Apellidos
                    </label>

                    <input
                        type="text"
                        name="apellidos"
                        class="form-control"
                        value="{{ old('apellidos', $usuario->apellidos_usu ?? '') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="correo"
                        class="form-control"
                        value="{{ old('correo', $usuario->correo_usu ?? '') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        class="form-control"
                        value="{{ old('telefono', $usuario->telefono_usu ?? '') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Tipo documento
                    </label>

                    <select
                        name="tipo_documento"
                        class="form-control"
                        required>

                        <option value="CC" @selected($tipoDoc === 'CC')>CC</option>

                        <option value="TI" @selected($tipoDoc === 'TI')>TI</option>

                        <option value="CE" @selected($tipoDoc === 'CE')>CE</option>

                        {{-- El usuario puede tener el tipo guardado como PA o PASAPORTE --}}
                        <option value="PASAPORTE" @selected(in_array($tipoDoc, ['PASAPORTE', 'PA']))>PASAPORTE</option>

                        <option value="NIT" @selected($tipoDoc === 'NIT')>NIT</option>

                        <option value="PEP" @selected($tipoDoc === 'PEP')>PEP</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Número documento
                    </label>

                    <input
                        type="text"
                        name="numero_documento"
                        class="form-control"
                        value="{{ old('numero_documento', $usuario->num_doc_usu ?? '') }}"
                        required>

                </div>

                <h5 class="border-bottom pb-2 mt-4 mb-3">
                    Información del formulario
                </h5>

                @foreach($formulario->campos->sortBy('orden') as $campo)

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            {{ $campo->etiqueta }}

                            @if($campo->obligatorio)

                                <span class="text-danger">*</span>

                            @endif

                        </label>

                        @php
                            $opciones = json_decode($campo->opciones, true) ?? [];
                        @endphp

                        @if($campo->tipo_campo == 'texto')

                            <input
                                type="text"
                                name="{{ $campo->etiqueta }}"
                                class="form-control"
                                @if($campo->obligatorio) required @endif>

                        @elseif($campo->tipo_campo == 'numero')

                            <input
                                type="number"
                                name="{{ $campo->etiqueta }}"
                                class="form-control"
                                @if($campo->obligatorio) required @endif>

                        @elseif($campo->tipo_campo == 'fecha')

                            <input
                                type="date"
                                name="{{ $campo->etiqueta }}"
                                class="form-control"
                                @if($campo->obligatorio) required @endif>

                        @elseif($campo->tipo_campo == 'email')

                            <input
                                type="email"
                                name="{{ $campo->etiqueta }}"
                                class="form-control"
                                @if($campo->obligatorio) required @endif>

                        @elseif($campo->tipo_campo == 'select')

                            <select
                                name="{{ $campo->etiqueta }}"
                                class="form-control"
                                @if($campo->obligatorio) required @endif>

                                <option value="">
                                    Seleccione...
                                </option>

                                @foreach($opciones as $opcion)

                                    <option value="{{ $opcion }}">
                                        {{ $opcion }}
                                    </option>

                                @endforeach

                            </select>

                        @elseif($campo->tipo_campo == 'radio')

                            @foreach($opciones as $opcion)

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="{{ $campo->etiqueta }}"
                                        value="{{ $opcion }}"
                                        @if($campo->obligatorio) required @endif>

                                    <label class="form-check-label">

                                        {{ $opcion }}

                                    </label>

                                </div>

                            @endforeach

                        @elseif($campo->tipo_campo == 'checkbox')

                            @foreach($opciones as $opcion)

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="{{ $campo->etiqueta }}[]"
                                        value="{{ $opcion }}">

                                    <label class="form-check-label">

                                        {{ $opcion }}

                                    </label>

                                </div>

                            @endforeach

                        @endif

                    </div>

                @endforeach

                <button
                    type="submit"
                    class="btn btn-success">

                    <i class="fa-solid fa-paper-plane me-2"></i>

                    Enviar formulario

                </button>

            </form>

        </div>

    </div>

</div>

@endsection