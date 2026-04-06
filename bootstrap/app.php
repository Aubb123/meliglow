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
        $middleware->alias([
            // Web Middlewares
            'web.auth' => App\Http\Middleware\Web\WebAuth::class,
            'web.guest' => App\Http\Middleware\Web\WebGuest::class,

            'web.check.user.email' => App\Http\Middleware\Web\WebCheckUserEmail::class,
            'web.check.user.phone' => App\Http\Middleware\Web\WebCheckUserPhone::class,
            'web.check.active.user.account' => App\Http\Middleware\Web\WebCheckActiveUserAccount::class,
            'web.check.role.user' => App\Http\Middleware\Web\WebCheckRoleUser::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
