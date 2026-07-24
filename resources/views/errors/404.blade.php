@extends('layouts.app')

@section('title','Página no encontrada')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">

    <div class="text-center">

        <div class="mb-4">

            <i class="fa-solid fa-triangle-exclamation text-warning" style="font-size:5rem;"></i>

        </div>

        <h1 class="display-4 fw-bold text-dark">404</h1>

        <h3 class="fw-semibold mb-3">Página no encontrada</h3>

        <p class="text-muted mb-4" style="max-width:520px; margin:auto;">
            La dirección que intentas acceder no existe o fue movida dentro del sistema Multitenant.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">

            <a href="/dashboard" class="btn btn-primary px-4">

                <i class="fa-solid fa-house me-2"></i>

                Ir al Dashboard

            </a>

            <a href="javascript:history.back()" class="btn btn-outline-secondary px-4">

                <i class="fa-solid fa-arrow-left me-2"></i>

                Volver

            </a>

        </div>

        <div class="mt-5">

            <small class="text-muted">

                Multitenant © {{ now()->year }} — {{ $usuarioActual->empresa->nombre_empresa ?? 'Sistema' }}

            </small>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Ruta anterior enviada por Laravel
    const anterior = @json(url()->previous());

    Swal.fire({
        icon: 'warning',
        title: 'Ruta no encontrada',
        text: 'La página solicitada no existe. Serás redirigido automáticamente.',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    }).then(() => {

        // Evitar bucle si la página anterior es la misma 404
        if (
            anterior &&
            anterior !== window.location.href &&
            !anterior.includes('/esto-no-existe')
        ) {
            window.location.href = anterior;
        } else {
            window.location.href = '/dashboard';
        }

    });

});
</script>
@endpush


