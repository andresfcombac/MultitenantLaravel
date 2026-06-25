@extends('layouts.app')

@section('title','Editar campo')

@section('content')

<h3>
Editar campo
</h3>


<form method="POST"
action="/formulario-campos/{{ $campo->id_campo }}/update">

@csrf


<div class="mb-3">

<label>
Formulario
</label>

<select name="id_formulario"
class="form-control">

@foreach($formularios as $formulario)

<option value="{{ $formulario->id_formulario }}"
@if($campo->id_formulario == $formulario->id_formulario)
selected
@endif
>

{{ $formulario->nombre_formulario }}

</option>

@endforeach

</select>

</div>



<div class="mb-3">

<label>
Etiqueta
</label>

<input type="text"
name="etiqueta"
class="form-control"
value="{{ $campo->etiqueta }}">

</div>



<div class="mb-3">

<label>
Tipo de campo
</label>


<select name="tipo_campo"
class="form-control">


<option value="texto"
@if($campo->tipo_campo=='texto') selected @endif>
Texto
</option>


<option value="numero"
@if($campo->tipo_campo=='numero') selected @endif>
Número
</option>


<option value="fecha"
@if($campo->tipo_campo=='fecha') selected @endif>
Fecha
</option>


<option value="email"
@if($campo->tipo_campo=='email') selected @endif>
Email
</option>


</select>

</div>




<div class="mb-3">

<label>
Opciones
</label>


<textarea name="opciones"
class="form-control">{{ $campo->opciones }}</textarea>


</div>



<div class="mb-3">

<label>
Orden
</label>


<input type="number"
name="orden"
class="form-control"
value="{{ $campo->orden }}">


</div>



<div class="form-check">

<input type="checkbox"
name="obligatorio"
value="1"

@if($campo->obligatorio)
checked
@endif

>

<label>
Obligatorio
</label>


</div>


<br>


<button class="btn btn-success">

Actualizar

</button>


<a href="/formulario-campos"
class="btn btn-secondary">

Cancelar

</a>


</form>


@endsection
