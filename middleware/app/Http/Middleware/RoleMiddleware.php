<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized action.'); // or use redirect()->route('notauth')
        }

        // If role is 'user' and the authenticated user's role is 'user'
        if ($role === 'user' && $request->user()->roles !== 'user') {
            return redirect()->route('user');
        }

        // If role is 'admin' and the authenticated user's role is 'admin'
        if ($role === 'admin' && $request->user()->roles !== 'admin') {
            return redirect()->route('admin');
        }

        return $next($request);
    }
}
