@extends('layouts.app')

@section('title', 'Empresas')

@section('content')

<div class="card">

    <div class="card-header">
        Empresas
    </div>
     
     <a
href="/empresas/create"
class="btn btn-primary mb-3"
>
Agregar Empresa
</a>
    <div class="card-body">

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>URL</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach($empresas as $empresa)

                    <tr>

                        <td>
                            {{ $empresa->id_empresa }}
                        </td>

                        <td>
                            {{ $empresa->nombre_empresa }}
                        </td>

                        <td>
                            {{ $empresa->url }}
                        </td>
                       <td>

    <a
        href="/empresas/{{ $empresa->id_empresa }}/edit"
        class="btn btn-warning btn-sm"
    >
        Editar
    </a>


    <form
        action="/empresas/{{ $empresa->id_empresa }}/delete"
        method="POST"
        style="display:inline;"
    >

        @csrf

        <button
            type="submit"
            class="btn btn-danger btn-sm"
            onclick="return confirm('¿Eliminar empresa?')"
        >
            Eliminar
        </button>

    </form>

</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
