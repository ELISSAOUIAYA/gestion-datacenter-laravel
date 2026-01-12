<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // <- obligatoire
use Illuminate\Support\Facades\Auth; // <- optionnel pour auth()

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) { // ou auth()->check()
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            abort(403, "Accès interdit");
        }

        return $next($request);
    }
}

