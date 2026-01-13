<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Cette méthode remplace la propriété $redirectTo pour une redirection dynamique.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // SÉCURITÉ : Si l'utilisateur n'a pas de rôle en base de données
        if (!$user->role) {
            return route('welcome'); 
        }

        $role = $user->role->name;

        // Redirection selon le nom exact du rôle
        switch ($role) {
            case 'Admin':
                return route('admin.dashboard');
            case 'Responsable Technique':
                return route('tech.dashboard');
            case 'Utilisateur Interne':
                return route('user.dashboard');
            default:
                return '/'; // Retour à l'accueil si le rôle est inconnu
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}