@extends('layouts.app')


@section('title','Respuestas del formulario')


@section('content')


<div class="container">


<h3>

Respuestas:

{{ $formulario->nombre_formulario }}

</h3>



<a href="/formularios"

class="btn btn-secondary mb-3">

Volver

</a>




<table class="table table-bordered">


<thead>


<tr>

<th>Nombres</th>

<th>Apellidos</th>

<th>Correo</th>

<th>Teléfono</th>

<th>Documento</th>

<th>Datos</th>

<th>Fecha</th>


</tr>


</thead>




<tbody>



@foreach($respuestas as $respuesta)



<tr>



<td>

{{ $respuesta->nombres }}

</td>



<td>

{{ $respuesta->apellidos }}

</td>



<td>

{{ $respuesta->correo }}

</td>



<td>

{{ $respuesta->telefono }}

</td>




<td>

{{ $respuesta->tipo_documento }}

<br>

{{ $respuesta->numero_documento }}

</td>





<td>


@foreach($respuesta->datos as $campo => $valor)



<strong>

{{ $campo }}

</strong>


:

{{ $valor }}


<br>


@endforeach


</td>




<td>

{{ $respuesta->fecha_respuesta }}

</td>



</tr>



@endforeach



</tbody>



</table>



</div>



@endsection
