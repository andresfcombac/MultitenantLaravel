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

        <button
            id="toggleSidebar"
            class="toggle-btn">

            <i class="fa-solid fa-bars"></i>

        </button>

        <img
            src="{{ asset('images/logo.png') }}"
            class="sidebar-logo"
            alt="Logo">

        <span class="sidebar-title">

            Multitenant

        </span>

    </div>

    <nav class="sidebar-menu">

        <a
            href="/dashboard"
            class="menu-item">

            <i class="fa-solid fa-house"></i>

            <span>

                Dashboard

            </span>

        </a>

        @if(session('rol') == 5)

        <a
            href="/empresas"
            class="menu-item">

            <i class="fa-solid fa-building"></i>

            <span>

                Empresas

            </span>

        </a>

        @endif

        <a
            href="/usuarios"
            class="menu-item">

            <i class="fa-solid fa-users"></i>

            <span>

                Usuarios

            </span>

        </a>

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

        <a
            href="/historico"
            class="menu-item">

            <i class="fa-solid fa-clock-rotate-left"></i>

            <span>

                Histórico

            </span>

        </a>

    </nav>
  <div class="sidebar-footer">

    <a
        href="/configuracion"
        class="menu-item">

        <i class="fa-solid fa-gear"></i>

        <span>

            Configuración

        </span>

    </a>

</div>

</aside>

    <div
        class="main-content">

        <header
    class="topbar">

    <div class="topbar-left">

        <h5 class="page-title">

            @yield('title','Dashboard')

        </h5>

    </div>

    <div class="topbar-right">

        <div class="user-info">

            <span class="user-name">

                {{ session('nombre') }}

            </span>

        </div>

        <a
            href="/logout"
            class="logout-btn">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>

                Salir

            </span>

        </a>

    </div>

</header>

        <main
            class="content-area">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif

            @yield('content')

        </main>

    </div>

</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>

<script src="{{ asset('js/datatables.js') }}"></script>

<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('js/layout.js') }}"></script>

@stack('scripts')

</body>

</html>