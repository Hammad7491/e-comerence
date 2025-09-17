<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Use as: ->middleware('role:admin') or ->middleware('role:admin,manager')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            abort(401);
        }

        $userRole = strtolower((string) $user->role);
        $roles    = array_map('strtolower', $roles);

        if (! in_array($userRole, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
