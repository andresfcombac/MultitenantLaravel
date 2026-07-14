<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('layouts.app', function ($view) {

        $usuarioActual = null;

        if (session()->has('usuario_id')) {

            $usuarioActual = Usuario::with(['rol', 'empresa'])
                ->find(session('usuario_id'));

        }

        $view->with('usuarioActual', $usuarioActual);

    });
}
}
