<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == "customer") {
                return redirect('/client/bundles');
            }
                //return redirect(RouteServiceProvider::HOME);
                $role_id=Auth::user()->role_id;
                $role="";
                if($role_id==1){
                    $role='admin';
                }else{
                    $role="notadmin";
                }
                switch ($role) {
                    case 'admin':
                        return redirect('/home');
                        break;
                    case 'notadmin':
                        return redirect('/manager/dashboard')->with("message","you do not have permission to view the page you have requested ");

                    default:
                        return redirect('/manager/dashboard');
                        # code...
                        break;
                }

        }


        return $next($request);
    }
}
