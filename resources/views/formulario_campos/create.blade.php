@extends('layouts.app')

@section('title','Crear campo')

@section('content')


<h3>
Crear campo de formulario
</h3>


<form method="POST" action="/formulario-campos/store">

@csrf


<div class="mb-3">

<label class="form-label">
Formulario
</label>


<select 
name="id_formulario"
class="form-control"
required
>


<option value="">
Seleccione formulario
</option>


@foreach($formularios as $formulario)


<option value="{{ $formulario->id_formulario }}">

{{ $formulario->nombre_formulario }}

-
{{ $formulario->actividad->nombre_actividad ?? '' }}


</option>


@endforeach


</select>


</div>



<div class="mb-3">

<label class="form-label">
Etiqueta
</label>


<input 
type="text"
name="etiqueta"
class="form-control"
required
>


</div>



<div class="mb-3">

<label class="form-label">
Tipo de campo
</label>


<select
name="tipo_campo"
class="form-control"
required
>


<option value="texto">
Texto
</option>


<option value="numero">
Numero
</option>


<option value="fecha">
Fecha
</option>


<option value="email">
Email
</option>


<option value="select">
Select
</option>


<option value="radio">
Radio
</option>


<option value="checkbox">
Checkbox
</option>


</select>


</div>



<div class="mb-3">

<label class="form-label">
Opciones
</label>


<textarea
name="opciones"
class="form-control">
</textarea>


</div>



<div class="mb-3">


<label>
Orden
</label>


<input
type="number"
name="orden"
class="form-control"
value="0"
>


</div>



<div class="mb-3">


<label>

<input
type="checkbox"
name="obligatorio"
value="1"
>

Campo obligatorio

</label>


</div>



<button class="btn btn-success">

Guardar

</button>


<a href="/formulario-campos"
class="btn btn-secondary">

Cancelar

</a>


</form>


@endsection
