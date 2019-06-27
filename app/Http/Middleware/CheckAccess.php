<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $access)
    {
        if (Auth::id() === $access) {
            return $next($request);
        }
        return redirect()->route('dashboard')->with('alert', 'Anda tidak memiliki hak untuk mengakses bagian sistem tersebut!');
    }
}
