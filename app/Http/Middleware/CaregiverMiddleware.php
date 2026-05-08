<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaregiverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && strtolower(auth()->user()->role) === 'caregiver') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}