<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CS
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
        if (Auth::check() && Auth::user()->roles->nama == 'CS') {
            return $next($request);
        }
        abort(403);
    }
}
