@extends('layouts.app')

@section('content')

<h3>
{{ $formulario->nombre_formulario }}
</h3>


<p>
Actividad:
{{ $formulario->actividad->nombre_actividad }}
</p>


<p>
Estado:

@if($formulario->estado)

Activo

@else

Inactivo

@endif

</p>



<h4>
Campos
</h4>


@foreach($formulario->campos as $campo)

<p>
{{ $campo->orden }}
-
{{ $campo->etiqueta }}
-
{{ $campo->tipo_campo }}
</p>

@endforeach


@endsection
