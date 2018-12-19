<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfCompany
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'company')
	{
	    if (Auth::guard($guard)->check() && Auth::guard($guard)->user()['verify'] == 1) {
	        return redirect('company/home');
	    }

	    return $next($request);
	}
}