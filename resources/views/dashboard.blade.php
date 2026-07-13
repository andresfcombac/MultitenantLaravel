@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="welcome-banner">

    <div>

        <h2>
            Hola, {{ $usuario->nombre_usu }} 👋
        </h2>

        <p>
            Resumen del sistema — {{ now()->format('d/m/Y') }}
        </p>

    </div>

    <i class="fa-solid fa-layer-group welcome-banner-icon"></i>

</div>

<div class="row g-4">

@if(session('rol') == 5)
<div class="col-md-6 col-xl-3">

    <a href="/empresas" class="stat-card">

        <div class="stat-icon" style="background:#0d6efd;">
            <i class="fa-solid fa-building"></i>
        </div>

        <div class="stat-info">
            <small>Empresas</small>
            <h3>{{ $estadisticas['empresas'] }}</h3>
        </div>

    </a>

</div>
@endif

<div class="col-md-6 col-xl-3">

    <a href="/usuarios" class="stat-card">

        <div class="stat-icon" style="background:#198754;">
            <i class="fa-solid fa-users"></i>
        </div>

        <div class="stat-info">
            <small>Usuarios</small>
            <h3>{{ $estadisticas['usuarios'] }}</h3>
        </div>

    </a>

</div>

<div class="col-md-6 col-xl-3">

    <a href="/formularios" class="stat-card">

        <div class="stat-icon" style="background:#ea6b19;">
            <i class="fa-solid fa-file-lines"></i>
        </div>

        <div class="stat-info">
            <small>Formularios</small>
            <h3>{{ $estadisticas['formularios'] }}</h3>
        </div>

    </a>

</div>

<div class="col-md-6 col-xl-3">

    <a href="/actividades" class="stat-card">

        <div class="stat-icon" style="background:#0dcaf0;">
            <i class="fa-solid fa-calendar-days"></i>
        </div>

        <div class="stat-info">
            <small>Actividades</small>
            <h3>{{ $estadisticas['actividades'] }}</h3>
        </div>

    </a>

</div>

<div class="col-md-6 col-xl-3">

    <a href="/formularios" class="stat-card">

        <div class="stat-icon" style="background:#6c757d;">
            <i class="fa-solid fa-list-check"></i>
        </div>

        <div class="stat-info">
            <small>Respuestas</small>
            <h3>{{ $estadisticas['respuestas'] }}</h3>
        </div>

    </a>

</div>

<div class="col-md-6 col-xl-3">

    <a href="/asistencias" class="stat-card">

        <div class="stat-icon" style="background:#dc3545;">
            <i class="fa-solid fa-user-check"></i>
        </div>

        <div class="stat-info">
            <small>Asistencias</small>
            <h3>{{ $estadisticas['asistencias'] }}</h3>
        </div>

    </a>

</div>

<div class="col-md-6 col-xl-3">

    <a href="/historico" class="stat-card">

        <div class="stat-icon" style="background:#212529;">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>

        <div class="stat-info">
            <small>Histórico</small>
            <h3>{{ $estadisticas['historico'] }}</h3>
        </div>

    </a>

</div>

</div>

<div class="quick-access-title">
    ACCESOS RÁPIDOS
</div>

<div class="row g-3">

    <div class="col-6 col-md-3">
        <a href="/actividades" class="quick-access-btn">
            <i class="fa-solid fa-calendar-days" style="color:#0dcaf0;"></i>
            Actividades
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="/asistencias" class="quick-access-btn">
            <i class="fa-solid fa-user-check" style="color:#dc3545;"></i>
            Asistencias
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="/formularios" class="quick-access-btn">
            <i class="fa-solid fa-file-lines" style="color:#ea6b19;"></i>
            Formularios
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="/usuarios" class="quick-access-btn">
            <i class="fa-solid fa-users" style="color:#198754;"></i>
            Usuarios
        </a>
    </div>

</div>

<div class="card mt-5 shadow-sm border-0">

<div class="card-body">

    <h5>
        Información del usuario
    </h5>

    <hr>

    <p>
        <strong>Correo:</strong>
        {{ $usuario->correo_usu }}
    </p>

    <p>
        <strong>Rol:</strong>
        {{ $usuario->rol?->nombre_rol }}
    </p>

    @if(session('rol') != 5)

    <p>
        <strong>Empresa:</strong>
        {{ $usuario->empresa?->nombre_empresa }}
    </p>

    @endif

</div>

</div>

@endsection
