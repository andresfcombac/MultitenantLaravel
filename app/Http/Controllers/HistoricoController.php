<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;

class HistoricoController extends Controller
{
    public function index()
    {
        $consulta = Asistencia::with([
            'respuesta.formulario',
            'usuario',
        ]);

        if (session('rol') != 5) {

            $consulta->whereHas(
                'respuesta.formulario.actividad',
                function ($q) {
                    $q->where('empresa_id', app('tenant_id'));
                }
            );

        }

        $historicos = $consulta
            ->orderBy(
                'fecha_confirmacion',
                'DESC'
            )
            ->get();

        return view(
            'historico.index',
            compact('historicos')
        );
    }
}
