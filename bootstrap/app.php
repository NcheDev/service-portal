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

        // -------------------------------
        // 1️⃣ Global middleware (runs on every request)
        // -------------------------------
        $middleware->prepend(\App\Http\Middleware\PreventBackHistory::class);
        $middleware->prepend(\App\Http\Middleware\NoCache::class);
        $middleware->prepend(\App\Http\Middleware\CatchExceptions::class); // optional

        // -------------------------------
        // 2️⃣ Route middleware aliases
        // -------------------------------
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // ✅ Custom middleware
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'nocache' => \App\Http\Middleware\NoCache::class,
            'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
