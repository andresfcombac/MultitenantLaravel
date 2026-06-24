@extends('layouts.app')

@section('title','Actividades')

@section('content')

<div class="d-flex justify-content-between mb-3">

<h3>
Actividades
</h3>

<a href="/actividades/create" class="btn btn-primary">
Crear actividad
</a>

</div>


<table class="table table-bordered">

<thead>

<tr>
<th>Nombre</th>
<th>Fecha</th>
<th>Hora inicio</th>
<th>Hora fin</th>
<th>Empresa</th>
<th>Acciones</th>

</tr>

</thead>


<tbody>

@foreach($actividades as $actividad)

<tr>

<td>
{{ $actividad->nombre_actividad }}
</td>


<td>
{{ $actividad->fecha }}
</td>


<td>
{{ $actividad->hora_inicio }}
</td>


<td>
{{ $actividad->hora_fin }}
</td>


<td>
{{ $actividad->empresa->nombre_empresa ?? 'Sin empresa' }}
</td>


<td>

<a href="/actividades/{{ $actividad->id_actividad }}/edit"
class="btn btn-warning btn-sm">

Editar

</a>


<form method="POST"
action="/actividades/{{ $actividad->id_actividad }}/delete"
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
