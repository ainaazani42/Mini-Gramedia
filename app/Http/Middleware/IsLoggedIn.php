<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsloggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    {
           if(Auth::check()) {

        return $next($request); //memperbolehkan melakuka aksi yang diminta
    } else {
        return redirect()->route('login')->with('error', 'silahkan login terlebih dahulu');
    }
    }
}

