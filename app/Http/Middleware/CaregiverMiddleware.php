<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaregiverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(strtolower(auth()->user()->role), ['caregiver', 'admin'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}