@extends('layouts.app')

@section('title','Crear formulario')

@section('content')

<div class="container-fluid mt-3">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">

                        {{ isset($formulario) ? 'Editar formulario' : 'Crear formulario' }}

                    </h5>

                </div>

                <div class="card-body">

                    <form method="POST" action="/formularios/store">

                        @csrf
                        <input
    type="hidden"
    name="campos_json"
    id="camposJson">

                        {{-- ========================= --}}
                        {{-- INFORMACIÓN GENERAL --}}
                        {{-- ========================= --}}

                        <div class="mb-3">

                            <label class="form-label">

                                Nombre del formulario

                            </label>

                            <input
                                type="text"
                                name="nombre_formulario"
                                class="form-control"
                                value="{{ old('nombre_formulario') }}">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Descripción

                            </label>

                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="3">{{ old('descripcion') }}</textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Actividad

                            </label>

                            <select
                                name="id_actividad"
                                class="form-control">

                                @foreach($actividades as $actividad)

                                    <option value="{{ $actividad->id_actividad }}">

                                        {{ $actividad->nombre_actividad }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- ========================= --}}
{{-- CONSTRUCTOR DE CAMPOS --}}
{{-- ========================= --}}

<div class="card mt-4 border-primary">

    <div class="card-header bg-primary text-white">

        <strong>

            Constructor de campos

        </strong>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Nombre del campo

                </label>

                <input
                    type="text"
                    id="nombreCampo"
                    class="form-control">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Tipo

                </label>

                <select
                    id="tipoCampo"
                    class="form-control">

                    <option value="texto">Texto</option>

                    <option value="numero">Número</option>

                    <option value="fecha">Fecha</option>

                    <option value="email">Email</option>

                    <option value="select">Select</option>

                    <option value="radio">Radio</option>

                    <option value="checkbox">Checkbox</option>

                </select>
<div
    class="col-md-12 mb-3"
    id="contenedorOpciones"
    style="display:none;">

    <label class="form-label">

        Opciones (separadas por coma)

    </label>

    <input
        type="text"
        id="opcionesCampo"
        class="form-control"
        placeholder="Ej: Masculino,Femenino">

</div>
            </div>

            <div class="col-md-2 mb-3 d-flex align-items-end">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="obligatorioCampo">

                    <label class="form-check-label">

                        Obligatorio

                    </label>

                </div>

            </div>

            <div class="col-md-3 mb-3 d-flex align-items-end">

                <button
                    type="button"
                    id="btnAgregarCampo"
                    class="btn btn-success w-100">

                    <i class="fa-solid fa-plus me-2"></i>

                    Agregar campo

                </button>
                {{-- El texto del botón será controlado por JavaScript --}}

            </div>

        </div>

    </div>

</div>


<div class="card mt-4 border-secondary">

    <div class="card-header bg-secondary text-white">

        <strong>

            Campos agregados

        </strong>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="table table-bordered table-hover align-middle"
                id="tablaCampos">

                <thead class="table-light">

                    <tr>

                        <th width="35%">Campo</th>

                        <th width="20%">Tipo</th>

                        <th width="15%">Obligatorio</th>

                        <th width="30%">Acciones</th>

                    </tr>

                </thead>

                <tbody id="tbodyCampos">

                       <tr id="filaSinCampos">

                        <td colspan="4" class="text-center text-muted">

                            Aún no hay campos agregados.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


 {{-- ========================= --}}
{{-- VISTA PREVIA --}}
{{-- ========================= --}}

<div class="mt-4">

    <button
        type="button"
        id="btnVistaPrevia"
        class="btn btn-outline-primary">

        <i class="fa-solid fa-eye me-2"></i>

        Mostrar vista previa

    </button>

</div>

<div
    id="contenedorVistaPrevia"
    class="card mt-3 border-info"
    style="display:none;">

    <div class="card-header bg-info text-white">

        <strong>

            Vista previa del formulario

        </strong>

    </div>

    <div class="card-body">

        <div id="previewFormulario">

            <div
    id="previewVacio"
    class="text-center text-muted py-4">

    <i class="fa-solid fa-file-lines fa-3x mb-3"></i>

    <p>

        Aún no hay campos para mostrar.

    </p>

</div>

</div>

    </div>

</div>

                        {{-- ========================= --}}
                        {{-- BOTONES --}}
                        {{-- ========================= --}}

                       <div class="d-flex justify-content-end gap-2">

    <a
        href="/formularios"
        class="btn btn-secondary">

        Volver

    </a>

    <button
        type="submit"
        id="btnGuardarFormulario"
        class="btn btn-primary">

        Guardar formulario

    </button>

</div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="{{ asset('js/form-builder.js') }}"></script>

@endpush