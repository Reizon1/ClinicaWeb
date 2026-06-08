<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ── Registro unificado de Middlewares personalizados ─────────────────
        $middleware->alias([
            'rol'        => \App\Http\Middleware\CheckRol::class,              // <── Middleware de accesos de tu compañera
            'two-factor' => \App\Http\Middleware\EnsureTwoFactorVerified::class, // <── Tu middleware de seguridad 2FA
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
