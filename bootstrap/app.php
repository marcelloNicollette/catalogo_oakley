<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;

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
            // Captura erros 419 (Page Expired / CSRF Token Mismatch)
            if ($e->getStatusCode() === 419) {
                return redirect('/acessos')->with('error', 'Sua sessão expirou. Por favor, faça login novamente.');
            }
        });

        // Captura erros de autorização
        $exceptions->render(function (AuthorizationException $e, $request) {
            return redirect('/acessos')->with('error', 'Acesso negado.');
        });

        // Captura especificamente TokenMismatchException
        $exceptions->render(function (TokenMismatchException $e, $request) {
            return redirect('/acessos')->with('error', 'Sua sessão expirou. Por favor, faça login novamente.');
        });
    })->create();
