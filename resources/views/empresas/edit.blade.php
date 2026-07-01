@extends('layouts.app')

@section('title','Editar Empresa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-building-pen me-2"></i>

            Editar Empresa

        </h2>

        <small class="text-muted">

            Actualización de la información de la empresa

        </small>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

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


<div class="d-flex gap-2">

    <button
        type="submit"
        class="btn btn-success">

        <i class="fa-solid fa-floppy-disk me-2"></i>

        Actualizar

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
