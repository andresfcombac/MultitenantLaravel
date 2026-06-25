@extends('layouts.app')

@section('title','Formularios')

@section('content')


<div class="d-flex justify-content-between mb-3">

<h3>
Formularios
</h3>


<a href="/formularios/create"
class="btn btn-primary">

Crear formulario

</a>


</div>




<table class="table table-bordered">


<thead>


<tr>

<th>Nombre</th>

<th>Actividad</th>

<th>Estado</th>

<th>Acciones</th>


</tr>


</thead>




<tbody>



@foreach($formularios as $formulario)



<tr>



<td>

{{ $formulario->nombre_formulario }}

</td>




<td>

{{ $formulario->actividad->nombre_actividad ?? 'Sin actividad' }}

</td>




<td>


@if($formulario->estado == 1)


<span class="badge bg-success">

Activo

</span>


@else


<span class="badge bg-danger">

Inactivo

</span>


@endif


</td>





<td>




{{-- VER FORMULARIO --}}


<a href="/formularios/{{ $formulario->id_formulario }}"

class="btn btn-secondary btn-sm">


Ver


</a>





{{-- VER RESPUESTAS --}}


<a href="/formularios/{{ $formulario->id_formulario }}/respuestas"

class="btn btn-info btn-sm">


Respuestas


</a>






{{-- EDITAR --}}


<a href="/formularios/{{ $formulario->id_formulario }}/edit"

class="btn btn-warning btn-sm">


Editar


</a>







{{-- ACTIVAR / DESACTIVAR --}}



@if($formulario->estado == 1)



<form action="/formularios/{{ $formulario->id_formulario }}/estado"

method="POST"

style="display:inline">


@csrf



<button type="submit"

class="btn btn-danger btn-sm"


onclick="return confirm('¿Desea desactivar este formulario?')">


Desactivar


</button>


</form>





@else





<form action="/formularios/{{ $formulario->id_formulario }}/estado"

method="POST"

style="display:inline">


@csrf



<button type="submit"

class="btn btn-success btn-sm"


onclick="return confirm('¿Desea activar este formulario?')">


Activar


</button>


</form>





@endif




</td>




</tr>




@endforeach




</tbody>



</table>




@endsection