<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificationCompany
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
        if(Auth::guard('company')->check() && Auth::guard('company')->user()['verify'] == 0){
            return redirect('/company/verify-company-account');
        }
        return $next($request);
    }
}
