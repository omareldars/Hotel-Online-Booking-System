<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Banned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->banned == 1) {
            return redirect()->route('ban');
        }

        return $next($request);
    }
}
