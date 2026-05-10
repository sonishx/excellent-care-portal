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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerifiedUnlessAdmin::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'caregiver' => \App\Http\Middleware\CaregiverMiddleware::class,
            'clinician' => \App\Http\Middleware\ClinicianMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
