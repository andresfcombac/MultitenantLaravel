@extends('layouts.app')

@section('title','Asistencia de la actividad')

@section('content')

<h3>{{ $actividad->nombre_actividad }}</h3>

<p>Total respuestas: {{ $respuestas->count() }}</p>

<table class="table">

    <thead>

        <tr>

            <th>Nombre</th>

            <th>Documento</th>

        </tr>

    </thead>

    <tbody>

    @foreach($respuestas as $respuesta)

        <tr>

            <td>{{ $respuesta->nombres }}</td>

            <td>{{ $respuesta->numero_documento }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@endsection