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
    'asistencia.usuario',
    'formulario.actividad',
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

    // Administrador y Supervisor solo pueden consultar datos de su empresa.
    // SuperAdmin y Validador QR conservan el alcance global definido para
    // esos roles en TenantMiddleware.
    if (
        ! in_array((int) session('rol'), [5, 6], true)
        && $respuesta->formulario?->actividad?->empresa_id != app('tenant_id')
    ) {
        return response()->view(
            'validador.no-encontrado',
            [],
            404
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

        $consulta = Asistencia::where(
            'id_respuesta',
            $request->codigo
        );

        // Control tenant: un Administrador/Supervisor/Validador QR solo
        // puede confirmar asistencias de respuestas que pertenezcan a
        // formularios de su propia empresa (mismo criterio que
        // AsistenciaController::confirmar). SuperAdmin no tiene restricción.
        if (! in_array(session('rol'), [5, 6])) {

            $consulta->whereHas(
                'respuesta.formulario.actividad',
                function ($q) {
                    $q->where('empresa_id', app('tenant_id'));
                }
            );

        }

        $asistencia = $consulta->first();

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
