@extends('layouts.app')

@section('title', $formulario->nombre_formulario)

@section('content')

<h3>{{ $formulario->nombre_formulario }}</h3>

<p>
<strong>Actividad:</strong>
{{ $formulario->actividad->nombre_actividad }}
</p>

<hr>

<form>

@foreach($formulario->campos->sortBy('orden') as $campo)

<div class="mb-3">

<label class="form-label">

{{ $campo->etiqueta }}

@if($campo->obligatorio)

<span class="text-danger">*</span>

@endif

</label>

@if($campo->tipo_campo == 'texto')

<input
type="text"
class="form-control"
placeholder="{{ $campo->etiqueta }}">

@elseif($campo->tipo_campo == 'numero')

<input
type="number"
class="form-control">

@elseif($campo->tipo_campo == 'fecha')

<input
type="date"
class="form-control">

@elseif($campo->tipo_campo == 'email')

<input
type="email"
class="form-control">

@elseif($campo->tipo_campo == 'select')

<select class="form-control">

<option value="">
Seleccione...
</option>

@foreach(json_decode($campo->opciones,true) ?? [] as $opcion)

<option value="{{ $opcion }}">

{{ $opcion }}

</option>

@endforeach

</select>

@elseif($campo->tipo_campo == 'radio')

@foreach(json_decode($campo->opciones,true) ?? [] as $opcion)

<div class="form-check">

<input
type="radio"
name="campo{{ $campo->id_campo }}"
class="form-check-input"
value="{{ $opcion }}">

<label class="form-check-label">

{{ $opcion }}

</label>

</div>

@endforeach

@elseif($campo->tipo_campo == 'checkbox')

@foreach(json_decode($campo->opciones,true) ?? [] as $opcion)

<div class="form-check">

<input
type="checkbox"
class="form-check-input"
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
class="btn btn-primary"
disabled>

Enviar (Vista previa)

</button>

<a
href="/formularios"
class="btn btn-secondary">

Volver

</a>

</form>

@endsection