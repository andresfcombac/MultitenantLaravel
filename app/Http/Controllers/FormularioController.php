<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{

    public function index()
    {

        $consulta = Formulario::with(
            'actividad'
        );


        // Control tenant

        if(session('rol') != 5){


            $consulta->whereHas(
                'actividad',
                function($q){

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            );


        }


        $formularios = $consulta->get();



        return view(
            'formularios.index',
            compact('formularios')
        );

    }




    public function create()
    {

        return view(
            'formularios.create'
        );

    }




    public function show($id)
    {


        if(session('rol') == 5){


            $formulario = Formulario::with(
                'campos',
                'actividad'
            )
            ->findOrFail($id);


        }else{


            $formulario = Formulario::with(
                'campos',
                'actividad'
            )
            ->whereHas(
                'actividad',
                function($q){

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            )
            ->findOrFail($id);


        }



        return view(
            'formularios.show',
            compact('formulario')
        );


    }

public function edit($id)
{


    if(session('rol') == 5){


        $formulario = Formulario::findOrFail($id);


    }else{


        $formulario = Formulario::whereHas(
            'actividad',
            function($q){

                $q->where(
                    'empresa_id',
                    app('tenant_id')
                );

            }
        )
        ->findOrFail($id);


    }



    // actividades disponibles

    if(session('rol') == 5){


        $actividades = \App\Models\Actividad::all();


    }else{


        $actividades = \App\Models\Actividad::where(
            'empresa_id',
            app('tenant_id')
        )
        ->get();


    }




    return view(
        'formularios.edit',
        compact(
            'formulario',
            'actividades'
        )
    );


}

    public function estado($id)
    {


        if(session('rol') == 5){


            $formulario = Formulario::findOrFail($id);


        }else{


            $formulario = Formulario::whereHas(
                'actividad',
                function($q){

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            )
            ->findOrFail($id);


        }



        $formulario->update([

            'estado' => $formulario->estado == 1 ? 0 : 1

        ]);



        return redirect('/formularios')
            ->with(
                'success',
                'Estado actualizado correctamente'
            );


    }

}