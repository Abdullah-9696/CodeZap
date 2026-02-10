<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enable Sanctum stateful API for SPA authentication (sessions + cookies)
        $middleware->statefulApi();
        // Exempt JSON profile endpoints from CSRF since SPA sends XSRF token via header
        $middleware->validateCsrfTokens(except: [
            'profile',
            'profile/update',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
