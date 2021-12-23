<?php

declare(strict_types=1);

namespace Auth0\Laravel\Http\Middleware;

final class AuthRequired
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(
        \Illuminate\Http\Request $request,
        \Closure $next
    ) {
        return $next($request);
    }
}
