<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // if (auth()->user()->role == $role) {
        //     return $next($request);
        // } else {
        //     abort(403);
        // }

        $user = Auth::user();

        $allowedRoles = ['admin', 'kasir', 'owner'];

        if (!in_array($user->role, $allowedRoles)) {
            abort(403);
        }

        return $next($request);
    }
}
