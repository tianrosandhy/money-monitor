<?php

namespace App\Core\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class AdminGuest
{

    public function handle($request, Closure $next)
    {
        $user = admin_guard()->check();
        if($user){
        	return redirect(admin_url('/'));
        }
        return $next($request);
    }

}
