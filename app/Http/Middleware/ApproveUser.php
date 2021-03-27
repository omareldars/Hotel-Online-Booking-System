<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApproveUser
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
        if (auth()->user()->approve == 0) {
            return redirect()->route('approve');
        }
        return $next($request);
    }
}
