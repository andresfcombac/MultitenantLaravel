@extends('layouts.app')

@section('title','Empresas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-0">

            <i class="fa-solid fa-building me-2"></i>

            Empresas

        </h2>

        <small class="text-muted">

            Administración de empresas registradas

        </small>

    </div>

    <a
        href="/empresas/create"
        class="btn btn-primary">

        <i class="fa-solid fa-plus me-2"></i>

        Nueva Empresa

    </a>

</div>


<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table
                id="tablaEmpresas"
                class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Empresa</th>

                        <th>URL</th>

                        <th width="150">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($empresas as $empresa)

                    <tr>

                        <td>

                            {{ $empresa->id_empresa }}

                        </td>

                        <td>

                            <strong>

                                {{ $empresa->nombre_empresa }}

                            </strong>

                        </td>

                        <td>

                            @if($empresa->url)

                                <span class="badge bg-info">

                                    {{ $empresa->url }}

                                </span>

                            @else

                                <span class="text-muted">

                                    Sin URL

                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="/empresas/{{ $empresa->id_empresa }}/edit"
                                    class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <form
                                    action="/empresas/{{ $empresa->id_empresa }}/delete"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar empresa?')">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

