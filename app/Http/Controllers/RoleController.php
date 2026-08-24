<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private const ROLES_SISTEMA = [1, 2, 3, 5, 6];

    private function esRolSistema(Role $rol): bool
    {
        return in_array((int) $rol->id_rol, self::ROLES_SISTEMA, true);
    }

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
            'nombre_rol' => 'required|max:50|unique:legacy.roles,nombre_rol',
        ]);

        Role::create([
            'nombre_rol' => $request->nombre_rol,
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

        if ($this->esRolSistema($rol)) {
            return redirect('/roles')->with(
                'error',
                'Los roles del sistema no pueden modificarse.'
            );
        }

        return view(
            'roles.edit',
            compact('rol')
        );
    }

    public function update(
        Request $request,
        $id
    ) {
        $rol = Role::findOrFail($id);

        if ($this->esRolSistema($rol)) {
            return redirect('/roles')->with(
                'error',
                'Los roles del sistema no pueden modificarse.'
            );
        }

        $request->validate([
            'nombre_rol' => 'required|max:50',
        ]);

        $rol->update([
            'nombre_rol' => $request->nombre_rol,
        ]);

        return redirect('/roles')
            ->with(
                'success',
                'Rol actualizado correctamente'
            );
    }

    public function destroy($id)
    {
        $rol = Role::findOrFail($id);

        if ($this->esRolSistema($rol)) {

            return redirect('/roles')
                ->with(
                    'error',
                    'Los roles del sistema no pueden eliminarse'
                );

        }

        if ($rol->usuarios()->count() > 0) {

            return redirect('/roles')
                ->with(
                    'error',
                    'No se puede eliminar porque tiene usuarios asociados'
                );
        }

        $rol->delete();

        return redirect('/roles')
            ->with(
                'success',
                'Rol eliminado correctamente'
            );

    }
}
