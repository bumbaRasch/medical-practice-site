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
        // Global middleware for all requests
        $middleware->append([
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
        
        // Register locale middleware for all web routes
        $middleware->web(append: [
            \App\Http\Middleware\LocaleMiddleware::class,
        ]);
        
        // Middleware aliases for easier use
        $middleware->alias([
            'responsecache' => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'performance.monitor' => \App\Http\Middleware\MonitorPerformance::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
