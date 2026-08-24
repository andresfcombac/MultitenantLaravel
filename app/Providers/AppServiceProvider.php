<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

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
