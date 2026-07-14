<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Expose-Headers' => 'Authorization',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json(null, 204, $headers);
        }

        return $next($request)->withHeaders($headers);
    }
}
