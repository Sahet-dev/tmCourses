<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $currentSessionId = session()->getId();

            // Check if the current session ID is valid
            $sessionExists = Session::where('user_id', $user->id)
                ->where('session_id', $currentSessionId)
                ->exists();

            if (!$sessionExists) {
                auth()->logout();
                return redirect('/login')->with('message', 'Your session has expired. Please log in again.');
            }
        }

        return $next($request);
    }
}
