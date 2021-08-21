<?php
namespace App\Http\Middleware;
use Closure;
use Illumminate\Auth\Middleware\Role as Middleware;
use Illuminate\Support\Facades\Auth;

class Role{
    public function handle($request,Closure $next, String $role){
        if(!Auth::check()){
            return redirect('/');
        }
        $user=Auth::user();
        $userrole='';
        if($user->role_id ==1){
            $userrole='admin';
        }else{
            $userrole='notadmin';
        }

        if($userrole==$role){
            return $next($request);
        }
        return redirect('/manager/dashboard');

    }
}
