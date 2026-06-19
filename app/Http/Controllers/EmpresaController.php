<?php

namespace App\Http\Controllers;

use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();

        return view(
            'empresas.index',
            compact('empresas')
        );
    }
}
