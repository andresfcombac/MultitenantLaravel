<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Empresa;
use App\Models\Formulario;
use App\Models\Actividad;
use App\Models\FormularioRespuesta;
use App\Models\Asistencia;
use App\Models\Historico;

class DashboardController extends Controller
{
    public function index()
    {

        if (!session()->has('usuario_id')) {

            return redirect('/login');

        }


        if(session('rol') == 5){

            $usuario = Usuario::with(
                'rol',
                'empresa'
            )
            ->findOrFail(
                session('usuario_id')
            );


        }else{


            $usuario = Usuario::with(
                'rol',
                'empresa'
            )
            ->where(
                'empresa_usu',
                session('empresa')
            )
            ->findOrFail(
                session('usuario_id')
            );


        }


       if(session('rol') == 5){

    $estadisticas = [

        'empresas'     => Empresa::count(),

        'usuarios'     => Usuario::count(),

        'formularios'  => Formulario::count(),

        'actividades'  => Actividad::count(),

        'respuestas'   => FormularioRespuesta::count(),

        'asistencias'  => Asistencia::count(),

        'historico'    => Historico::count()

    ];

}else{

    $empresaId = session('empresa');

    $estadisticas = [

        'usuarios' => Usuario::where(
            'empresa_usu',
            $empresaId
        )->count(),

        'formularios' => Formulario::whereHas(
            'actividad',
            function($q) use ($empresaId){
                $q->where('empresa_id', $empresaId);
            }
        )->count(),

        'actividades' => Actividad::where(
            'empresa_id',
            $empresaId
        )->count(),

        'respuestas' => FormularioRespuesta::whereHas(
            'formulario.actividad',
            function($q) use ($empresaId){
                $q->where('empresa_id', $empresaId);
            }
        )->count(),

        'asistencias' => Asistencia::whereHas(
            'respuesta.formulario.actividad',
            function($q) use ($empresaId){
                $q->where('empresa_id', $empresaId);
            }
        )->count(),

        'historico' => 0

    ];

}

return view(
    'dashboard',
    compact(
        'usuario',
        'estadisticas'
    )
);

    }
}