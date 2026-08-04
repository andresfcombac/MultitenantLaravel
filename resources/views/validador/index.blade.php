@extends('layouts.app')

@section('title','Validador QR')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h4>Validador QR</h4>

        </div>

        <div class="card-body">

            @if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

@if(session('warning'))

<div class="alert alert-warning">

    {{ session('warning') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

    {{ session('error') }}

</div>

@endif

<form
    method="POST"
    action="{{ route('validador.confirmar') }}"
>

    @csrf

    <div class="mb-3">

        <label class="form-label">

            Código QR

        </label>

        <input
            type="text"
            name="codigo"
            class="form-control"
            autofocus
            required
        >

    </div>

    <button
        class="btn btn-success"
    >

        <i class="fa-solid fa-qrcode me-1"></i>

        Confirmar asistencia

    </button>

</form>

        </div>

    </div>

</div>

@endsection