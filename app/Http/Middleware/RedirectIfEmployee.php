<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfEmployee
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'employee')
	{
	    if (Auth::guard($guard)->check() && Auth::guard($guard)->user()['verify'] == 1) {
	        return redirect('employee/home');
	    }
	    return $next($request);
	}
}