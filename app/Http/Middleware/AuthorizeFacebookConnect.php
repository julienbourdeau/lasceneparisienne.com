<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeFacebookConnect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return optional($request->user())->isSuperAdmin() ? $next($request) : abort(404);
    }
}
