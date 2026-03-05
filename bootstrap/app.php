<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jwt.auth' => \App\Http\Middleware\JwtMiddleware::class,
            // JANGAN tambahin 'role' => ... kalau gak pakai
        ]);

        // Exclude login dari CSRF
        $middleware->validateCsrfTokens(except: [
            '/login',
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.check' => \App\Http\Middleware\CheckGuest::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.check' => \App\Http\Middleware\CheckGuest::class,
            'auth.check' => \App\Http\Middleware\CheckAuth::class, // tambah ini
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.check' => \App\Http\Middleware\CheckGuest::class,
            'auth.check' => \App\Http\Middleware\CheckAuth::class,
            'role.admin' => \App\Http\Middleware\CheckAdmin::class,
            'role.kepala_lurah' => \App\Http\Middleware\CheckKepalaLurah::class,
            'role.sekre' => \App\Http\Middleware\CheckSekre::class,
            'role.staff' => \App\Http\Middleware\CheckStaff::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
