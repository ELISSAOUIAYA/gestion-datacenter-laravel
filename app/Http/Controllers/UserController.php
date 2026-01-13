<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Affiche l'espace personnel de l'utilisateur interne.
     * Gère l'historique, le suivi des statuts et les filtres.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // 1. On prépare la requête pour récupérer les réservations de l'utilisateur
        $query = Reservation::where('user_id', $user->id)
                            ->with('resource');

        // 2. Gestion des filtres (Recherche par ressource ou par statut)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Récupération des données (Trié par le plus récent)
        $reservations = $query->latest()->get();

        // 4. Statistiques rapides pour le dashboard
        $stats = [
            'total' => $reservations->count(),
            'en_attente' => $reservations->where('status', 'en_attente')->count(),
            'validees' => $reservations->where('status', 'validée')->count(),
        ];

        // 5. TRÈS IMPORTANT : On envoie la variable 'reservations' à la vue
        // C'est ce qui corrige ton erreur "Undefined variable"
        return view('user.dashboard', compact('reservations', 'stats'));
    }

    /**
     * Permet à l'utilisateur de visualiser les ressources disponibles.
     */
    public function resources()
    {
        $resources = Resource::where('status', 'available')->with('category')->get();
        return view('user.resources', compact('resources'));
    }
}