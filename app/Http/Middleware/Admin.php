<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
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
        if (!Auth::guest() && Auth::user()->isAdmin())
            return $next($request);
		else
            return back()->with('error', 'You are not an administrator.');
    }
}
