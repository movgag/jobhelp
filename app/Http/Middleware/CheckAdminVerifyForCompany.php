<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminVerifyForCompany
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
        if(Auth::guard('company')->check() && Auth::guard('company')->user()['admin_verify'] == 0) {

            $request->session()->flash('message','Your account is not still verified by admin!');
            $request->session()->flash('type','info');
            return redirect()->back();
        }

        return $next($request);

    }
}
