<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //Register Global middleware
        // $middleware->append(ForceJsonResponse::class);
        //Register API route only
        // $middleware->api(append: [
        //     ForceJsonResponse::class
        // ]);
        // Register Alias middleware to use any route or group of route.
        $middleware->alias(['force.JSON' => ForceJsonResponse::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Handle JSON response globally for api when not using Accep: Application/Json in header
        // $exceptions->render(function (ValidationException $e, $request){
        //     //  if ($request->expectsJson()) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'VALIDATION_ERROR',
        //             'errors' => $e->errors(),
        //         ], $e->status);
        //     // }
        // });

    })->create();
