<?php
// In app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Ensure the user is authenticated
        if (!$user) {
            return redirect('/login');
        }

        // Check if the user has the required role
        if (!in_array($user->role, explode(',', $role))) {
            return redirect('/unauthorized');
        }

        return $next($request);
    }

}
