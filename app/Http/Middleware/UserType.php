<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,...$type)
    {
        $user=Auth::user();
       /* if( $user->type == 'admin'){

            abort(403,'you are not admin!');
        }*/
      
        if(!in_array($user->type,$type)){

             abort(403,'you are not admin!');
        }
        return $next($request);
    }
}
