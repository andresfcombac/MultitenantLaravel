<?php

namespace App\Http\Controllers;

use App\Models\FormularioRespuesta;
use App\Models\Asistencia;

class AsistenciaController extends Controller
{
   public function index()
{
    $respuestas = FormularioRespuesta::with([
    'formulario.actividad.empresa',
    'asistencia.usuario'
])
->orderBy('fecha_respuesta', 'DESC')
->get();

    return view(
        'asistencias.index',
        compact('respuestas')
    );
}
    
    public function confirmar($id)
{
    $respuesta = FormularioRespuesta::findOrFail($id);

    if ($respuesta->asistencia) {

        return back()->with(
            'warning',
            'La asistencia ya fue confirmada.'
        );

    }

    Asistencia::create([

        'id_respuesta' => $respuesta->id_respuesta,

        'confirmado_por' => session('usuario_id'),

        'fecha_confirmacion' => now()

    ]);

    return back()->with(
        'success',
        'Asistencia confirmada correctamente.'
    );
}
}