<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidateApiToken
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        $token = $request->header('X-API-Token');

        if ($token !== config('chat.api_token')) {
            return response()->json([
                'error' => 'Invalid API token'
            ], 401);
        }

        return $next($request);
    }
}
