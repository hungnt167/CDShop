<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use libraries\Authen;

class MyMiddleware
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
        //ck login
        if(Authen::check() == false) {
            return redirect('auth/login');
        }
        if(Authen::checkPermission() == false) {
            return view('errors.access_deny');
        }

//        $userInfo = Authen::getUser();
//        $role_id = $userInfo['role_id'];
//        if($role_id == 1 || $role_id == 2){
//
//        } else {
//
//        var_dump(Session::get('user'));
        return $next($request);
    }
}
