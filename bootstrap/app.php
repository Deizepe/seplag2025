<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Middleware\TokenExpirationMiddleware;
use App\Middleware\CorsMiddleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php', // 👈 aqui carrega API
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'token.expire' => TokenExpirationMiddleware::class, // 👈 registra o middleware aqui
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

    $middleware->global([
        CorsMiddleware::class,
    ]);
    