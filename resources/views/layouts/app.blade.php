<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        @yield('title','Multitenant Laravel')

    </title>

    <link rel="stylesheet"
      href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">

<link rel="stylesheet"
      href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

<link rel="stylesheet"
      href="{{ asset('assets/plugins/datatables/dataTables.dataTables.min.css') }}">

<link rel="stylesheet"
      href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">

<link rel="stylesheet"
      href="{{ asset('css/layout.css') }}">

</head>

<body>

<div class="wrapper">

    <aside
    class="sidebar"
    id="sidebar">

    <div class="sidebar-header">

    <img
        src="{{ asset('images/logo.png') }}"
        class="sidebar-logo"
        alt="Logo">

    <div>

        <div class="sidebar-title">

            Multitenant

        </div>

        <small class="text-light sidebar-subtitle">

            {{ $usuarioActual->empresa->nombre_empresa ?? 'Empresa' }}

        </small>

    </div>

</div>

<div class="px-3 py-3 border-bottom text-center">

    <div
        class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center"
        style="width:60px;height:60px;font-size:24px;">

        {{ strtoupper(substr(session('nombre'),0,1)) }}

    </div>

    <div class="mt-2 fw-bold">

        {{ session('nombre') }}

        {{ $usuarioActual->apellidos_usu ?? '' }}

    </div>

    <small class="text-secondary">

{{ $usuarioActual->rol->nombre_rol ?? 'Usuario' }}

    </small>

</div>

    <nav class="sidebar-menu">
        
        @php

    $rolNombre = $usuarioActual->rol->nombre_rol ?? null;

    // Gestión operativa por empresa
    $menuGestion = in_array($rolNombre, [
        'SuperAdmin',
        'Administrador',
        'Supervisor'
    ]);

    // Administración de empresa / sistema
    $menuAdministracion = in_array($rolNombre, [
        'SuperAdmin',
        'Administrador'
    ]);

@endphp
        <a
            href="/dashboard"
            class="menu-item">

            <i class="fa-solid fa-house"></i>

            <span>

                Dashboard

            </span>

        </a>

@if($rolNombre === 'SuperAdmin')

        <a
            href="/empresas"
            class="menu-item">

            <i class="fa-solid fa-building"></i>

            <span>

                Empresas

            </span>

        </a>

        @endif

        @if($menuGestion)

<a
    href="/usuarios"
    class="menu-item">

    <i class="fa-solid fa-users"></i>

    <span>
        Usuarios
    </span>

</a>

@endif

<a
    href="/formularios"
    class="menu-item">

    <i class="fa-solid fa-file-lines"></i>

    <span>
        Formularios
    </span>

</a>
        <a
            href="/actividades"
            class="menu-item">

            <i class="fa-solid fa-calendar-days"></i>

            <span>

                Actividades

            </span>

        </a>

        <a
            href="/asistencias"
            class="menu-item">

            <i class="fa-solid fa-user-check"></i>

            <span>

                Asistencias

            </span>

        </a>

        @if($menuGestion)
              <a
               
            href="/historico"
            class="menu-item">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>
                Histórico
            </span>
        </a>
        @endif
    </nav>
  <div class="sidebar-footer">
    @if($menuAdministracion)
    <a
        href="/configuracion"   class="menu-item">
        <i class="fa-solid fa-gear"></i>
        <span>
            Configuración
        </span>
    </a>
    @endif
</div>

</aside>

    <div
        class="main-content">

        <header
    class="topbar">

    <div class="topbar-left">

        <button
            id="toggleSidebar"
            class="toggle-btn toggle-btn-topbar">

            <i class="fa-solid fa-bars"></i>

        </button>

        <h5 class="page-title">

            @yield('title','Dashboard')

        </h5>

    </div>

   <div class="topbar-right">

    <div class="dropdown">

        <button
            class="btn btn-light border dropdown-toggle d-flex align-items-center"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <div
                class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2"
                style="width:36px;height:36px;font-weight:bold;">

                {{ strtoupper(substr(session('nombre'),0,1)) }}

            </div>

            <div class="text-start">

                <div class="fw-bold">

                    {{ session('nombre') }}

                    {{ $usuarioActual->apellidos_usu ?? '' }}

                </div>

                <small class="text-muted">

                    {{ $usuarioActual->rol->nombre_rol ?? 'Usuario' }}

                </small>

            </div>

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">

            <li>

                <h6 class="dropdown-header">

                    {{ session('nombre') }}

                    {{ $usuarioActual->apellidos_usu ?? '' }}

                </h6>

            </li>

            <li>
                <a class="dropdown-item" href="{{ route('perfil') }}">
                    <i class="fa-solid fa-user me-2"></i>
                    Mi perfil
                </a>
            </li>
            @@if($menuAdministracion)
<li>
    <a class="dropdown-item" href="/configuracion">
        <i class="fa-solid fa-gear me-2"></i>
        Configuración
    </a>
</li>

            <li><hr class="dropdown-divider"></li>

            <li>

                <a class="dropdown-item text-danger" href="/logout">

                    <i class="fa-solid fa-right-from-bracket me-2"></i>

                    Cerrar sesión

                </a>

            </li>

        </ul>

    </div>

</div>

</header>

        <main
            class="content-area">
            @yield('content')
        </main>
        <footer class="app-footer">
            Multitenant &copy; {{ now()->year }} — {{ $usuarioActual->empresa->nombre_empresa ?? 'Sistema' }}
        </footer>
    </div>
</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>

<script src="{{ asset('js/datatables.js') }}"></script>

<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('js/layout.js') }}"></script>

@if(session('success'))

<script>

Swal.fire({

    icon:'success',

    title:'Proceso exitoso',

    text:@json(session('success')),

    confirmButtonColor:'#0d6efd'

});

</script>

@endif


@if(session('error'))

<script>

Swal.fire({

    icon:'error',

    title:'Acceso denegado',

    text:@json(session('error')),

    confirmButtonColor:'#dc3545'

});

</script>

@endif


@if(session('warning'))

<script>

Swal.fire({

    icon:'warning',

    title:'Advertencia',

    text:@json(session('warning')),

    confirmButtonColor:'#ffc107'

});

</script>

@endif


@if(session('info'))

<script>

Swal.fire({

    icon:'info',

    title:'Información',

    text:@json(session('info')),

    confirmButtonColor:'#0dcaf0'

});

</script>

@endif

@stack('scripts')



</body>

</html>