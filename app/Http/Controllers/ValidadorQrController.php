<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;

class ValidadorQrController extends Controller
{
    public function index()
    {
        return view('validador.index');
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

        return back()->with(
            'success',
            'Asistencia confirmada correctamente.'
        );
    }
}