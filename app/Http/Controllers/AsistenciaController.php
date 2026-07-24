<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\FormularioRespuesta;

class AsistenciaController extends Controller
{
    public function index()
    {
        $consulta = FormularioRespuesta::with([
            'formulario.actividad.empresa',
            'asistencia.usuario',
        ]);

        if (session('rol') != 5) {

            $consulta->whereHas(
                'formulario.actividad',
                function ($q) {
                    $q->where('empresa_id', app('tenant_id'));
                }
            );

        }

        $respuestas = $consulta
            ->orderBy('fecha_respuesta', 'DESC')
            ->get();

        return view(
            'asistencias.index',
            compact('respuestas')
        );
    }

public function confirmar($id)
{
    $consulta = FormularioRespuesta::query();

    if (session('rol') != 5) {

        $consulta->whereHas(
            'formulario.actividad',
            function ($q) {
                $q->where('empresa_id', app('tenant_id'));
            }
        );

    }

    $respuesta = $consulta->find($id);

    // Validación de acceso
    if (! $respuesta) {

        return redirect('/actividades')
            ->with(
                'error',
                'No tiene permisos para confirmar esta asistencia.'
            );

    }

    // Ya confirmada
    if (
        $respuesta->asistencia &&
        $respuesta->asistencia->estado_asistencia === 'confirmado'
    ) {

        return back()->with(
            'warning',
            'La asistencia ya fue confirmada.'
        );

    }

    // Confirmación QR / operativa
    Asistencia::updateOrCreate(
        ['id_respuesta' => $respuesta->id_respuesta],
        [
            'estado_asistencia' => 'confirmado',
            'confirmado_por' => session('usuario_id'),
            'fecha_confirmacion' => now(),
        ]
    );

    return back()->with(
        'success',
        'Asistencia confirmada correctamente.'
    );
}


}
