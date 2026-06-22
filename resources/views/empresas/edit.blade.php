@extends('layouts.app')

@section('title','Editar Empresa')

@section('content')

<h2>Editar Empresa</h2>


<form method="POST" action="/empresas/{{ $empresa->id_empresa }}/update">

@csrf


<div class="mb-3">

<label>
Nombre empresa
</label>

<input
type="text"
name="nombre_empresa"
class="form-control"
value="{{ $empresa->nombre_empresa }}"
>

</div>


<div class="mb-3">

<label>
URL
</label>

<input
type="text"
name="url"
class="form-control"
value="{{ $empresa->url }}"
>

</div>


<div class="mb-3">

<label>
Imagen
</label>

<input
type="text"
name="img"
class="form-control"
value="{{ $empresa->img }}"
>

</div>


<button class="btn btn-success">
Actualizar
</button>


</form>

@endsection
