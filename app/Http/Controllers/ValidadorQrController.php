<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\FormularioRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionAsistenciaMail;

class ValidadorQrController extends Controller
{
    public function index()
    {
        return view('validador.index');
    }

public function validar($token)
{
   $respuesta = FormularioRespuesta::with([
    'asistencia.usuario'
])->where(
    'qr_token',
    $token
)->first();

    if (! $respuesta) {

        return response()->view(
            'validador.no-encontrado',
            [],
            404
        );

    }


    if (
        $respuesta->asistencia &&
        $respuesta->asistencia->estado_asistencia === 'confirmado'
    ) {

        return view(
            'validador.confirmado',
            compact('respuesta')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Usuario visitante escaneando QR
    |--------------------------------------------------------------------------
    */

    if (! session()->has('usuario_id')) {

        return view(
            'validador.espera',
            compact('respuesta')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Personal autorizado
    | 5  SuperAdmin
    | 3  Administrador
    | 1  Supervisor
    | 6  Validador QR
    |--------------------------------------------------------------------------
    */

    if (
        ! in_array(
            session('rol'),
            [1,3,5,6]
        )
    ) {

        return view(
            'validador.espera',
            compact('respuesta')
        );

    }


    return view(
        'validador.confirmar',
        compact('respuesta')
    );
}

    public function confirmar(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $asistencia = Asistencia::where(
            'id_respuesta',
            $request->codigo
        )->first();

        if (! $asistencia) {

            return back()->with(
                'error',
                'Código QR no encontrado.'
            );

        }

        if (
            $asistencia->estado_asistencia === 'confirmado'
        ) {

            return back()->with(
                'warning',
                'La asistencia ya fue confirmada.'
            );

        }

        $asistencia->update([

            'estado_asistencia' => 'confirmado',

            'confirmado_por' => session('usuario_id'),

            'fecha_confirmacion' => now(),

        ]);

        $respuesta = $asistencia->respuesta;
        
if ($respuesta && $respuesta->correo) {

    Mail::to($respuesta->correo)
        ->send(
            new ConfirmacionAsistenciaMail($respuesta)
        );

}
        return back()->with(
            'success',
            'Asistencia confirmada correctamente.'
        );
    }
}