@extends('layouts.app')

@section('title','Editar campo')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-pen-to-square me-2"></i>

            Editar campo

        </h2>

        <small class="text-muted">

            Modifique la configuración del campo seleccionado.

        </small>

    </div>

</div>

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

<option value="select"
@if($campo->tipo_campo=='select') selected @endif>
Select
</option>

<option value="radio"
@if($campo->tipo_campo=='radio') selected @endif>
Radio
</option>

<option value="checkbox"
@if($campo->tipo_campo=='checkbox') selected @endif>
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
    rows="5">@if($campo->opciones){{ implode("\n", json_decode($campo->opciones, true) ?? []) }}@endif</textarea>


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


<div class="mt-4">

    <button class="btn btn-primary">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Actualizar

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
