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

    if(session('rol') == 5){

        $actividades = \App\Models\Actividad::all();

    }else{

        $actividades = \App\Models\Actividad::where(
            'empresa_id',
            app('tenant_id')
        )->get();

    }


    return view(
        'formularios.create',
        compact('actividades')
    );

}

public function store(Request $request)
{


    $request->validate([

        'nombre_formulario' => 'required|max:255',

        'descripcion' => 'nullable',

        'id_actividad' => 'required'

    ]);




    // validar actividad según tenant

    if(session('rol') == 5){


        $actividad = \App\Models\Actividad::findOrFail(
            $request->id_actividad
        );


    }else{


        $actividad = \App\Models\Actividad::where(
            'empresa_id',
            app('tenant_id')
        )
        ->findOrFail(
            $request->id_actividad
        );


    }





    Formulario::create([


        'nombre_formulario' => $request->nombre_formulario,


        'descripcion' => $request->descripcion,


        'imagen_fondo' => null,


        'id_actividad' => $request->id_actividad,


        'estado' => 1,


        'creado_por' => session('usuario_id')


    ]);


    return redirect('/formularios')

    ->with(

        'success',

        'Formulario creado correctamente'

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