<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaregiverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'caregiver' role
        if (auth()->check() && auth()->user()->role === 'caregiver') {
            return $next($request); // Allow the request to proceed
        }

        // If not a caregiver, redirect to the dashboard or another page
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }
}