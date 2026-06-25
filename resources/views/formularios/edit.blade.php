@extends('layouts.app')

@section('title','Editar formulario')

@section('content')


<h3>
Editar formulario
</h3>


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




<button class="btn btn-primary">

Actualizar

</button>



<a href="/formularios"
class="btn btn-secondary">

Cancelar

</a>



</form>


@endsection
