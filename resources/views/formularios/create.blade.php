@extends('layouts.app')

@section('title','Crear formulario')

@section('content')


<h3>
Crear formulario
</h3>


<form method="POST" action="/formularios/store">

@csrf


<div class="mb-3">

<label>
Nombre formulario
</label>

<input 
type="text"
name="nombre_formulario"
class="form-control">

</div>


<div class="mb-3">

<label>
Descripción
</label>

<textarea
name="descripcion"
class="form-control"></textarea>

</div>



<div class="mb-3">

<label>
Actividad
</label>


<select name="id_actividad"
class="form-control">


@foreach($actividades as $actividad)

<option value="{{ $actividad->id_actividad }}">

{{ $actividad->nombre_actividad }}

</option>


@endforeach


</select>


</div>



<button class="btn btn-success">

Guardar

</button>


</form>


@endsection
