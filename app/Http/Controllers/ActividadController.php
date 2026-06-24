<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        $consulta = Actividad::with('empresa');

        if (session('rol') != 5) {

            $consulta->where(
                'empresa_id',
                app('tenant_id')
            );

        }

        $actividades = $consulta->get();

        return view(
            'actividades.index',
            compact('actividades')
        );
    }

    public function create()
{

    if(session('rol') == 5){

        $empresas = Empresa::all();

    }else{

        $empresas = Empresa::where(
            'id_empresa',
            app('tenant_id')
        )->get();

    }


    return view(
        'actividades.create',
        compact('empresas')
    );

}

    public function store(Request $request)
{
    $request->validate([

        'nombre_actividad' => 'required|max:100',
        'descripcion' => 'nullable',
        'fecha' => 'required|date',
        'hora_inicio' => 'nullable',
        'hora_fin' => 'nullable'

    ]);


    Actividad::create([

        'nombre_actividad' => $request->nombre_actividad,

        'descripcion' => $request->descripcion,

        'fecha' => $request->fecha,

        'hora_inicio' => $request->hora_inicio,

        'hora_fin' => $request->hora_fin,


        'empresa_id' => session('rol') == 5
            ? $request->empresa_id
            : app('tenant_id')

    ]);


    return redirect('/actividades')
        ->with(
            'success',
            'Actividad creada correctamente'
        );

}


public function edit($id)
{

    if(session('rol') == 5){

        $actividad = Actividad::findOrFail($id);

    }else{

        $actividad = Actividad::where(
            'empresa_id',
            app('tenant_id')
        )
        ->findOrFail($id);

    }


    $empresas = Empresa::all();


    return view(
        'actividades.edit',
        compact(
            'actividad',
            'empresas'
        )
    );

}



public function update(Request $request, $id)
{


    if(session('rol') == 5){

        $actividad = Actividad::findOrFail($id);

    }else{

        $actividad = Actividad::where(
            'empresa_id',
            app('tenant_id')
        )
        ->findOrFail($id);

    }


    $request->validate([

        'nombre_actividad' => 'required|max:100',
        'descripcion' => 'nullable',
        'fecha' => 'required|date'

    ]);


    $actividad->update([

        'nombre_actividad' => $request->nombre_actividad,

        'descripcion' => $request->descripcion,

        'fecha' => $request->fecha,

        'hora_inicio' => $request->hora_inicio,

        'hora_fin' => $request->hora_fin,


        'empresa_id' => session('rol') == 5
            ? $request->empresa_id
            : app('tenant_id')

    ]);


    return redirect('/actividades')
        ->with(
            'success',
            'Actividad actualizada correctamente'
        );

}

public function destroy($id)
{

    if(session('rol') == 5){

        $actividad = Actividad::findOrFail($id);

    }else{

        $actividad = Actividad::where(
            'empresa_id',
            app('tenant_id')
        )
        ->findOrFail($id);

    }


    $actividad->delete();


    return redirect('/actividades')
        ->with(
            'success',
            'Actividad eliminada correctamente'
        );

}
}