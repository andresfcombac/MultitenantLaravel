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

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="/formularios"
                                class="btn btn-secondary">

                                Volver

                            </a>

                            <button
                                type="submit"
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