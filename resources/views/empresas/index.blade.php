@extends('layouts.app')

@section('title', 'Empresas')

@section('content')

<div class="card">

    <div class="card-header">
        Empresas
    </div>

    <div class="card-body">

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>URL</th>
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

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
