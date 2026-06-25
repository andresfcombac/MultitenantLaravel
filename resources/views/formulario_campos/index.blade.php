@extends('layouts.app')

@section('title','Campos del formulario')

@section('content')

<div class="d-flex justify-content-between mb-3">

<h3>
Campos de formularios
</h3>


<a href="/formulario-campos/create"
class="btn btn-primary">

Crear campo

</a>


</div>


<table class="table table-bordered">

<thead>

<tr>

<th>Formulario</th>
<th>Etiqueta</th>
<th>Tipo</th>
<th>Obligatorio</th>
<th>Orden</th>
<th>Acciones</th>

</tr>

</thead>


<tbody>


@foreach($campos as $campo)


<tr>


<td>

{{ $campo->formulario->nombre_formulario ?? 'Sin formulario' }}

</td>


<td>

{{ $campo->etiqueta }}

</td>


<td>

{{ $campo->tipo_campo }}

</td>


<td>

{{ $campo->obligatorio ? 'Si':'No' }}

</td>


<td>

{{ $campo->orden }}

</td>


<td>


<a href="/formularios/{{ $campo->id_formulario }}"
class="btn btn-info btn-sm">

Ver formulario

</a>


<a href="/formulario-campos/{{ $campo->id_campo }}/edit"
class="btn btn-warning btn-sm">

Editar

</a>



<form method="POST"
action="/formulario-campos/{{ $campo->id_campo }}/delete"
style="display:inline">

@csrf

<button class="btn btn-danger btn-sm">

Eliminar

</button>

</form>


</td>


</tr>


@endforeach


</tbody>


</table>


@endsection