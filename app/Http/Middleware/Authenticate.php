<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //return $request->expectsJson() ? null : route('login');
		
		 if (! $request->expectsJson()) {

            if($request->routeIs('admin.*')){
                return route('admin.login');
            }
            if($request->routeIs('doctor.*')){
                return route('doctor.login');
            }
            if($request->routeIs('agent.*')){
                return route('agent.login');
            }
            if($request->routeIs('partner.*')){
                return route('partner.login');
            }
            return route('user.login');
        }
    }
}
