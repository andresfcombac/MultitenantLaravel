@extends('layouts.app')

@section('title', $formulario->nombre_formulario)

@section('content')

<h3>{{ $formulario->nombre_formulario }}</h3>

<p>{{ $formulario->descripcion }}</p>

<form method="POST" action="/formularios/{{ $formulario->id_formulario }}/responder">

    @csrf

    @foreach($formulario->campos->sortBy('orden') as $campo)

        <div class="mb-3">

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


    <button class="btn btn-success">

        Enviar formulario

    </button>

</form>

@endsection