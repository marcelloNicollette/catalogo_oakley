<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Captura erros 403 (Forbidden)
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return redirect('/acessos')->with('error', 'Você não tem permissão para acessar este recurso.');
            }
        });

        // Captura erros de autorização
        $exceptions->render(function (AuthorizationException $e, $request) {
            return redirect('/acessos')->with('error', 'Acesso negado.');
        });
    })->create();
