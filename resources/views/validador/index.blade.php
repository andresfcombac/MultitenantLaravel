@extends('layouts.app')

@section('title','Validador QR')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h4>

                <i class="fa-solid fa-qrcode me-2"></i>

                Validador QR

            </h4>

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

            <div class="mb-4">

                <div
                    id="reader"
                    style="width:350px; max-width:100%;">
                </div>

            </div>

            <form
                method="POST"
                action="{{ route('validador.confirmar') }}"
            >

                @csrf

                <input
                    type="hidden"
                    id="codigo"
                    name="codigo"
                >

                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="fa-solid fa-qrcode me-1"></i>

                    Confirmar asistencia

                </button>

            </form>

        </div>

    </div>

</div>

<script src="{{ asset('assets/js/html5-qrcode/html5-qrcode.min.js') }}"></script>

<script>

function onScanSuccess(decodedText)
{

    let partes = decodedText.split('/');

    let token = partes[partes.length - 1];


    fetch('/validador/' + token)
        .then(response => response.text())
        .then(html => {

            document.open();

            document.write(html);

            document.close();

        });

}

const scanner = new Html5QrcodeScanner(

    "reader",

    {

        fps: 10,

        qrbox: 250,

        rememberLastUsedCamera: true

    },

    false

);

scanner.render(onScanSuccess);

</script>

@endsection