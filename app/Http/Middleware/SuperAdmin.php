<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->roles[0]->name == 'Super Admin') {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
