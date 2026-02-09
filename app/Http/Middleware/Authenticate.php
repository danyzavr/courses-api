<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token || $token !== 'Bearer ' . env('GLOBAL_API_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
