<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request);
        // Force 'Accept' header to be application/json
        $request->headers->set('Accept', 'application/json');
        // if (!$request->expectsJson()){
        //     return response()->json(["message"=> "Please add Accept: Application/Json in header"], Response::HTTP_BAD_REQUEST);
        // }
        return $next($request);
    }
}
