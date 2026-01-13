<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // pour le helper auth() type-safe

class RoleMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté a le rôle requis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = Auth::guard(); // type-safe pour l'IDE

        // Si l'utilisateur n'est pas connecté → redirection login
        if (!$auth->check()) {
            return redirect('/login');
        }

        // Si le rôle ne correspond pas → accès interdit
        if ($auth->user()->role !== $role) {
            abort(403, "Accès interdit");
        }

        return $next($request);
    }
}
