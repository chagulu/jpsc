<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfNotCandidate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // -------------------------------
        // 1) Global middleware (runs on every request)
        // -------------------------------
        $middleware->append(\Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class);

        // -------------------------------
        // 2) Route middleware aliases
        // -------------------------------
        $middleware->alias([
            'auth'           => Authenticate::class,              // default admin auth
            'guest'          => RedirectIfAuthenticated::class,  // admin guest
            'auth.candidate' => RedirectIfNotCandidate::class,   // candidate auth
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
