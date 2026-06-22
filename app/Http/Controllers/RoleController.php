<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('usuarios')->get();

        return view(
            'roles.index',
            compact('roles')
        );
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|max:50'
        ]);

        Role::create([
            'nombre_rol' => $request->nombre_rol
        ]);

        return redirect('/roles')
            ->with(
                'success',
                'Rol creado correctamente'
            );
    }

public function edit($id)
{
    $rol = Role::findOrFail($id);

    return view(
        'roles.edit',
        compact('rol')
    );
}

public function update(
    Request $request,
    $id
)
{
    $rol = Role::findOrFail($id);

    $request->validate([
        'nombre_rol' => 'required|max:50'
    ]);

    $rol->update([
        'nombre_rol' => $request->nombre_rol
    ]);

    return redirect('/roles')
        ->with(
            'success',
            'Rol actualizado correctamente'
        );
}
}
