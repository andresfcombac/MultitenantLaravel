@extends('layouts.app')

@section('title','Crear campo')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-list-check me-2"></i>

            Crear campo

        </h2>

        <small class="text-muted">

            Agregue un nuevo campo al formulario.

        </small>

    </div>

</div>

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

<label>
Opciones
</label>

<textarea
name="opciones"
class="form-control"
rows="5"
placeholder="Escriba una opción por línea&#10;Bogotá&#10;Medellín&#10;Cali"></textarea>

<small class="text-muted">

Solo aplica para campos tipo:
<strong>Select</strong>,
<strong>Radio</strong> y
<strong>Checkbox</strong>.

Escriba una opción por cada línea.

</small>

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

<div class="mt-4">

    <button class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Guardar

    </button>

    <a href="/formulario-campos"
       class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Cancelar

    </a>

</div>

</form>

    </div>

</div>

@endsection
