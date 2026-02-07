<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting( /** Carga las rutas del sisietma */
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    ) /**withMiddleware() -> registra middlewares, por ejemplo auth */
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'auth' => Authenticate::class,
        ]);

    }) /**withMiddleware() -> Configura como manejar errores y exeptions  */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create(); /** Arranca la aplicacion con todo lo anterior */
