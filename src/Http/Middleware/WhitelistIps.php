<?php

namespace Biigle\RemoteQueue\Http\Middleware;

use Closure;

class WhitelistIps
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
        $whitelist = config('remote-queue.accept_ips');

        $token = $request->bearerToken();
        if (empty($whitelist) || in_array($request->ip(), $whitelist)) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
