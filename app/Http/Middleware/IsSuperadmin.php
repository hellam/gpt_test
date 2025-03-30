<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperadmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('api')->check() && auth('api')->user()->isSuperadmin()) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
