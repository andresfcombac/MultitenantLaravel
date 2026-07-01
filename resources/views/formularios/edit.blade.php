@extends('layouts.app')

@section('title','Editar formulario')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-file-pen me-2"></i>

            Editar Formulario

        </h2>

        <small class="text-muted">

            Actualización de la información del formulario

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

<form method="POST" action="/formularios/{{ $formulario->id_formulario }}/update">

@csrf



<div class="mb-3">

<label>
Nombre formulario
</label>

<input 
type="text"
name="nombre_formulario"
class="form-control"
value="{{ $formulario->nombre_formulario }}">


</div>



<div class="mb-3">

<label>
Descripción
</label>


<textarea
name="descripcion"
class="form-control">{{ $formulario->descripcion }}</textarea>


</div>




<div class="mb-3">

<label>
Actividad
</label>


<select name="id_actividad"
class="form-control">


@foreach($actividades as $actividad)


<option value="{{ $actividad->id_actividad }}"

@if($actividad->id_actividad == $formulario->id_actividad)

selected

@endif

>

{{ $actividad->nombre_actividad }}

</option>


@endforeach


</select>


</div>


<div class="d-flex gap-2">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Actualizar

    </button>

    <a
        href="/formularios"
        class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Volver

    </a>

</div>

</form>

    </div>

</div>


@endsection
