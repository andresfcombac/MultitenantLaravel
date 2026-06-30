<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;

class HistoricoController extends Controller
{
    public function index()
    {
        $historicos = Asistencia::with([
            'respuesta.formulario',
            'usuario'
        ])
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