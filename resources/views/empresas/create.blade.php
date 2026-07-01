@extends('layouts.app')

@section('title','Crear Empresa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-building-circle-check me-2"></i>

            Crear Empresa

        </h2>

        <small class="text-muted">

            Registro de una nueva empresa

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

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


<div class="d-flex gap-2">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Guardar

    </button>

    <a
        href="/empresas"
        class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Volver

    </a>

</div>

</form>

    </div>

</div>

@endsection
