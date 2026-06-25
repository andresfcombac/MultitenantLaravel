<?php

namespace App\Http\Controllers;


use App\Models\Formulario;
use App\Models\FormularioRespuesta;


class FormularioRespuestaController extends Controller
{


public function index($id)
{


    $formulario = Formulario::findOrFail($id);



    $respuestas = FormularioRespuesta::where(
        'id_formulario',
        $id
    )
    ->get();



    return view(
        'formularios.respuestas',
        compact(
            'formulario',
            'respuestas'
        )
    );


}


}
