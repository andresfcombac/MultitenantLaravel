<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        $usuario = Usuario::with('rol', 'empresa')
            ->find(session('usuario_id'));

        return view('dashboard', compact('usuario'));
    }
}
