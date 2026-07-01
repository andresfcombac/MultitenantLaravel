@extends('layouts.app')

@section('title','Campos del formulario')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

```
<div>

    <h2 class="fw-bold mb-0">

        <i class="fa-solid fa-list-check me-2"></i>

        Campos del formulario

    </h2>

    <small class="text-muted">

        Administración de campos dinámicos

    </small>

</div>

<a
    href="/formulario-campos/create"
    class="btn btn-primary">

    <i class="fa-solid fa-plus me-2"></i>

    Nuevo Campo

</a>
```

</div>

<div class="card shadow-sm border-0">

```
<div class="card-body">

    <div class="table-responsive">

        <table
    id="tablaCampos"
    class="table table-hover align-middle datatable">

            <thead class="table-light">

                <tr>

                    <th>Formulario</th>

                    <th>Etiqueta</th>

                    <th>Tipo</th>

                    <th>Obligatorio</th>

                    <th>Orden</th>

                    <th width="220">

                        Acciones

                    </th>

                </tr>

            </thead>

            <tbody>

            @foreach($campos as $campo)

                <tr>

                    <td>

                        <strong>

                            {{ $campo->formulario->nombre_formulario ?? 'Sin formulario' }}

                        </strong>

                    </td>

                    <td>

                        {{ $campo->etiqueta }}

                    </td>

                    <td>

                        @php

                            $iconos = [

                                'texto'     => 'fa-font',

                                'numero'    => 'fa-hashtag',

                                'fecha'     => 'fa-calendar-days',

                                'hora'      => 'fa-clock',

                                'select'    => 'fa-list',

                                'radio'     => 'fa-circle-dot',

                                'checkbox'  => 'fa-square-check',

                                'archivo'   => 'fa-paperclip',

                                'imagen'    => 'fa-image',

                                'firma'     => 'fa-signature'

                            ];

                            $icono = $iconos[strtolower($campo->tipo_campo)] ?? 'fa-circle';

                        @endphp

                        <i class="fa-solid {{ $icono }} me-2"></i>

                        {{ ucfirst($campo->tipo_campo) }}

                    </td>

                    <td>

                        @if($campo->obligatorio)

                            <span class="badge bg-success">

                                Sí

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                        @endif

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            {{ $campo->orden }}

                        </span>

                    </td>

                    <td>

                        <div class="d-flex gap-2">

                            <a
                                href="/formularios/{{ $campo->id_formulario }}"
                                class="btn btn-info btn-sm"
                                title="Ver formulario">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a
                                href="/formulario-campos/{{ $campo->id_campo }}/edit"
                                class="btn btn-warning btn-sm"
                                title="Editar">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form
                                action="/formulario-campos/{{ $campo->id_campo }}/delete"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm btn-delete"
                                    title="Eliminar">

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
```

</div>

@endsection

