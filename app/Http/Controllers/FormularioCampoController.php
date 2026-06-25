<?php

namespace App\Http\Controllers;

use App\Models\FormularioCampo;
use App\Models\Formulario;
use Illuminate\Http\Request;

class FormularioCampoController extends Controller
{

public function store(Request $request)
{

    $request->validate([

        'id_formulario' => 'required',
        'etiqueta' => 'required|max:255',
        'tipo_campo' => 'required',
        'opciones' => 'nullable',
        'orden' => 'nullable|integer'

    ]);


    $formulario = Formulario::with('actividad')
        ->findOrFail(
            $request->id_formulario
        );


    // Validación tenant
    if(session('rol') != 5){

        if(
            $formulario->actividad->empresa_id
            != app('tenant_id')
        ){

            abort(
                403,
                'Acceso no autorizado'
            );

        }

    }


    FormularioCampo::create([

        'id_formulario' => $request->id_formulario,

        'etiqueta' => $request->etiqueta,

        'tipo_campo' => $request->tipo_campo,

        'opciones' => $request->opciones,

        'obligatorio' => $request->obligatorio ?? 0,

        'orden' => $request->orden ?? 0

    ]);


    return redirect('/formulario-campos')
        ->with(
            'success',
            'Campo creado correctamente'
        );

}
}