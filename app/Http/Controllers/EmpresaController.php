<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

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


    public function create()
    {
        return view('empresas.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|max:100',
            'url' => 'nullable|max:100'
        ]);


        Empresa::create([
            'nombre_empresa' => $request->nombre_empresa,
            'url' => $request->url,
            'img' => $request->img
        ]);


        return redirect('/empresas')
            ->with(
                'success',
                'Empresa creada correctamente'
            );
    }
public function edit($id)
{
    $empresa = Empresa::findOrFail($id);

    return view(
        'empresas.edit',
        compact('empresa')
    );
}


public function update(Request $request, $id)
{
    $request->validate([
        'nombre_empresa' => 'required|max:100',
        'url' => 'nullable|max:100'
    ]);


    $empresa = Empresa::findOrFail($id);


    $empresa->update([
        'nombre_empresa' => $request->nombre_empresa,
        'url' => $request->url,
        'img' => $request->img
    ]);


    return redirect('/empresas')
        ->with(
            'success',
            'Empresa actualizada correctamente'
        );
}

public function destroy($id)
{
    $empresa = Empresa::withCount('usuarios')
        ->findOrFail($id);


    if ($empresa->usuarios_count > 0) {

        return redirect('/empresas')
            ->with(
                'error',
                'No se puede eliminar la empresa porque tiene usuarios asociados'
            );
    }


    $empresa->delete();


    return redirect('/empresas')
        ->with(
            'success',
            'Empresa eliminada correctamente'
        );
}
}
