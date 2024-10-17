<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckHC;
use App\Http\Middleware\CheckKapro;
use App\Http\Middleware\CheckManajerHC;
use App\Http\Middleware\CheckPegawai;
use App\Http\Middleware\CheckPusat;
use App\Http\Middleware\FinanceMiddleware;
use App\Http\Middleware\KlienMiddleware;
use App\Http\Middleware\PmMiddleware;
use App\Http\Middleware\Team_leadMiddleware;
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
        $middleware->appendToGroup('pm', [
            PmMiddleware::class,
            
        ]);
        $middleware->appendToGroup('team_lead', [
            Team_leadMiddleware::class,
            
        ]);
        $middleware->appendToGroup('finance', [
            FinanceMiddleware::class,
            
        ]);
        $middleware->appendToGroup('klien', [
            KlienMiddleware::class,
            
        ]);
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
