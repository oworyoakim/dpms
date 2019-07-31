<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($user = Sentinel::check()){
            return $next($request);
        }
//        if($request->ajax()){
//            return response()->json('Unauthorized access!',Response::HTTP_UNAUTHORIZED);
//        }
        return redirect('/login');
    }
}
