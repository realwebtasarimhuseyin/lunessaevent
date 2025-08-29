<?php

use App\Http\Middleware\AddHeaders;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\KuponKontrolMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\VeriPaylasim;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([AddHeaders::class, VeriPaylasim::class]);
        $middleware->validateCsrfTokens([
            'odeme/durum'
        ]);
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'auth.admin' => AdminMiddleware::class,
            'kupon.kontrol' => KuponKontrolMiddleware::class,
            'yetki' => PermissionMiddleware::class
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
