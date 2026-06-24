@extends('layouts.app')

@section('title','Crear actividad')

@section('content')


<h3>
Crear actividad
</h3>


<form method="POST" action="/actividades/store">

@csrf


<div class="mb-3">

<label>
Nombre actividad
</label>

<input 
type="text"
name="nombre_actividad"
class="form-control"
required>

</div>



<div class="mb-3">

<label>
Descripción
</label>

<textarea
name="descripcion"
class="form-control">
</textarea>

</div>



<div class="mb-3">

<label>
Fecha
</label>

<input
type="date"
name="fecha"
class="form-control"
required>

</div>



<div class="mb-3">

<label>
Hora inicio
</label>

<input
type="time"
name="hora_inicio"
class="form-control">

</div>



<div class="mb-3">

<label>
Hora fin
</label>

<input
type="time"
name="hora_fin"
class="form-control">

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

<option value="{{ $empresa->id_empresa }}">

{{ $empresa->nombre_empresa }}

</option>


@endforeach


</select>

</div>

@endif



<button class="btn btn-success">

Guardar

</button>


</form>


@endsection
