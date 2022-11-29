<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class KaptainDapur
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
        if (Auth::check() && Auth::user()->roles->nama == 'Kaptain Dapur') {
            return $next($request);
        }
        abort(403);
    }
}
