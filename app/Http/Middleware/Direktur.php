<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Direktur
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
        if (Auth::check() && Auth::user()->roles->nama == 'Direktur') {
            return $next($request);
        }
        abort(403);
    }
}
