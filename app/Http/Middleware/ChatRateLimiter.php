<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ChatRateLimiter
{
    public function handle(Request $request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        $key = sprintf(
            'chat_rate_limit:%s:%s',
            $request->ip(),
            $request->route()->getName()
        );

        $hits = Redis::incr($key);

        if ($hits === 1) {
            Redis::expire($key, $decayMinutes * 60);
        }

        if ($hits > $maxAttempts) {
            return response()->json([
                'error' => 'Too many requests. Please try again later.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return $next($request);
    }
}
