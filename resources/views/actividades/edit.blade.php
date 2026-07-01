@extends('layouts.app')

@section('title','Editar actividad')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-calendar-check me-2"></i>

            Editar Actividad

        </h2>

        <small class="text-muted">

            Actualización de la información de la actividad

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

<form method="POST" action="/actividades/{{ $actividad->id_actividad }}/update">

@csrf


<div class="mb-3">

<label>
Nombre actividad
</label>

<input
type="text"
name="nombre_actividad"
class="form-control"
value="{{ $actividad->nombre_actividad }}"
required>

</div>



<div class="mb-3">

<label>
Descripción
</label>

<textarea
name="descripcion"
class="form-control">{{ $actividad->descripcion }}</textarea>

</div>



<div class="mb-3">

<label>
Fecha
</label>

<input
type="date"
name="fecha"
class="form-control"
value="{{ $actividad->fecha }}"
required>

</div>



<div class="mb-3">

<label>
Hora inicio
</label>

<input
type="time"
name="hora_inicio"
class="form-control"
value="{{ $actividad->hora_inicio }}">

</div>



<div class="mb-3">

<label>
Hora fin
</label>

<input
type="time"
name="hora_fin"
class="form-control"
value="{{ $actividad->hora_fin }}">

</div>



@if(session('rol') == 5)

<div class="mb-3">

<label>
Empresa
</label>


<select
name="empresa_id"
class="form-control">


@foreach($empresas as $empresa)

<option
value="{{ $empresa->id_empresa }}"

@if($actividad->empresa_id == $empresa->id_empresa)

selected

@endif

>

{{ $empresa->nombre_empresa }}

</option>


@endforeach


</select>


</div>

@endif

<div class="d-flex gap-2">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Actualizar

    </button>

    <a
        href="/actividades"
        class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Volver

    </a>

</div>

</form>

    </div>

</div>

@endsection
