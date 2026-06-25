@extends('layouts.app')

@section('title','Formulario')

@section('content')


<div class="container">


<h3>
{{ $formulario->nombre_formulario }}
</h3>


<p>
{{ $formulario->descripcion }}
</p>



@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif



<form method="POST"
action="/formulario/{{ $formulario->id_formulario }}/respuesta">


@csrf



<h5 class="mt-4">
Datos personales
</h5>



<div class="mb-3">

<label>
Nombres
</label>

<input type="text"
name="nombres"
class="form-control"
required>

</div>




<div class="mb-3">

<label>
Apellidos
</label>

<input type="text"
name="apellidos"
class="form-control"
required>

</div>




<div class="mb-3">

<label>
Correo
</label>

<input type="email"
name="correo"
class="form-control"
required>

</div>




<div class="mb-3">

<label>
Teléfono
</label>

<input type="text"
name="telefono"
class="form-control"
required>

</div>




<div class="mb-3">

<label>
Tipo documento
</label>


<select name="tipo_documento"
class="form-control"
required>


<option value="CC">
CC
</option>


<option value="TI">
TI
</option>


<option value="CE">
CE
</option>


<option value="PASAPORTE">
PASAPORTE
</option>


<option value="NIT">
NIT
</option>


<option value="PEP">
PEP
</option>


</select>


</div>




<div class="mb-3">

<label>
Número documento
</label>


<input type="text"
name="numero_documento"
class="form-control"
required>


</div>





<hr>


<h5>
Información del formulario
</h5>




@foreach($formulario->campos as $campo)



<div class="mb-3">


<label>

{{ $campo->etiqueta }}

</label>



@if($campo->tipo_campo == 'texto')


<input type="text"

name="{{ $campo->etiqueta }}"

class="form-control"

@if($campo->obligatorio)
required
@endif

>



@elseif($campo->tipo_campo == 'numero')


<input type="number"

name="{{ $campo->etiqueta }}"

class="form-control"

@if($campo->obligatorio)
required
@endif

>




@elseif($campo->tipo_campo == 'fecha')


<input type="date"

name="{{ $campo->etiqueta }}"

class="form-control"

@if($campo->obligatorio)
required
@endif

>



@elseif($campo->tipo_campo == 'email')


<input type="email"

name="{{ $campo->etiqueta }}"

class="form-control"

@if($campo->obligatorio)
required
@endif

>



@endif



</div>


@endforeach




<button class="btn btn-success">

Enviar formulario

</button>



</form>



</div>



@endsection
