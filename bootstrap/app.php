<?php

use App\Http\Middleware\AuthSessionMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Solo se confía en proxies de redes privadas (la red interna de
        // Docker es 172.x/10.x/192.168.x). Confiar en '*' permitiría a
        // cualquier cliente suplantar su IP vía X-Forwarded-For y burlar
        // el rate limiting del login.
        $middleware->trustProxies(
            at: '10.0.0.0/8,172.16.0.0/12,192.168.0.0/16,127.0.0.1'
        );
        $middleware->alias([

            'auth.session' => AuthSessionMiddleware::class,

            'tenant' => TenantMiddleware::class,

            'superadmin' => SuperAdminMiddleware::class,

            'role' => RoleMiddleware::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

            if ($request->is('api/*')) {
                return null;
            }

            return response()->view('errors.404', [], 404);

        });

    })
    ->create();

