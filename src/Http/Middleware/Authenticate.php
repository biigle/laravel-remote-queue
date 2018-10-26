<?php

namespace Biigle\RemoteQueue\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        if ($token && in_array($token, config('remote-queue.accept-tokens'))) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
