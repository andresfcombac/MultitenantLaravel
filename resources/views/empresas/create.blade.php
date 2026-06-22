@extends('layouts.app')

@section('title','Crear Empresa')

@section('content')

<h2>Crear Empresa</h2>


<form method="POST" action="/empresas/store">

@csrf


<div class="mb-3">

<label>
Nombre empresa
</label>

<input
type="text"
name="nombre_empresa"
class="form-control"
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
>

</div>


<button class="btn btn-success">

Guardar

</button>


</form>

@endsection
