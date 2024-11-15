<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Exception $exception, $request) {

            if ($request->is('api/*')) {
                if ($exception instanceof NotFoundHttpException) {
                    return response()->json(['message' => 'Resource not found.'], 404);
                }

                if ($exception instanceof ModelNotFoundException) {
                    return response()->json(['message' => 'Resource not found.'], 404);
                }
            }

            return null;
        });
    })->create();