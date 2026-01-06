<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            if ($user->role === 'staff') {
                return redirect()->route('staff.dashboard')->with('error', 'Anda tidak memiliki akses untuk masuk ke halaman tersebut.');
            }
            if ($user->role === 'guest') {
                return redirect()->route('guest.dashboard')->with('error', 'Anda tidak memiliki akses untuk masuk ke halaman tersebut.');
            }
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
