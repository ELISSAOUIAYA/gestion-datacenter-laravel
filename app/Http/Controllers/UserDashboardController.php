<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Affiche le dashboard personnel de l'utilisateur
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Demandes en attente et approuvées
        $reservations = Reservation::where('user_id', $user->id)
            ->with('resource')
            ->latest()
            ->get();

        // Ressources disponibles selon le type d'utilisateur
        // Les utilisateurs avec user_type peuvent réserver TOUS les équipements disponibles
        // Les utilisateurs sans user_type ne peuvent réserver que les équipements faibles (VM, Stockage, Réseau)
        if ($user->user_type) {
            // Utilisateur interne : tous les équipements sauf les serveurs puissants
            $availableResources = Resource::where('status', 'available')
                ->with('category')
                ->orderBy('resource_category_id')
                ->get();
        } else {
            // Utilisateur normal : seulement VM, Stockage, Réseau (pas les Serveurs puissants)
            $availableResources = Resource::where('status', 'available')
                ->whereIn('resource_category_id', [2, 3, 4]) // Exclure catégorie 1 (Serveurs)
                ->with('category')
                ->orderBy('resource_category_id')
                ->get();
        }

        // Notifications non lues
        $unreadNotifications = $user->notifications()
            ->where('is_read', false)
            ->get();

        return view('user.dashboard', compact(
            'reservations',
            'availableResources',
            'unreadNotifications'
        ));
    }

    /**
     * Affiche l'historique des réservations avec filtres
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $query = Reservation::where('user_id', $user->id)->with('resource');

        // Filtre par statut
        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filtre par ressource
        if ($request->filled('resource_id') && $request->resource_id !== '') {
            $query->where('resource_id', $request->resource_id);
        }

        // Filtre par date (début)
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        // Filtre par date (fin)
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $reservations = $query->latest()->paginate(15);
        $resources = Resource::with('category')->get();
        $statuses = ['EN ATTENTE', 'VALIDÉE', 'REFUSÉE'];

        return view('user.history', compact('reservations', 'resources', 'statuses'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle réservation
     */
    public function createReservation(Resource $resource = null)
    {
        $user = Auth::user();

        // Ressources disponibles selon le type d'utilisateur
        // Les utilisateurs avec user_type peuvent réserver TOUS les équipements disponibles
        // Les utilisateurs sans user_type ne peuvent réserver que les équipements faibles (VM, Stockage, Réseau)
        if ($user->user_type) {
            // Utilisateur interne : tous les équipements
            $resources = Resource::where('status', 'available')
                ->with('category')
                ->orderBy('resource_category_id')
                ->get();
        } else {
            // Utilisateur normal : seulement VM, Stockage, Réseau (pas les Serveurs puissants)
            $resources = Resource::where('status', 'available')
                ->whereIn('resource_category_id', [2, 3, 4]) // Exclure catégorie 1 (Serveurs)
                ->with('category')
                ->orderBy('resource_category_id')
                ->get();
            
            // Si une ressource est spécifiée mais qu'elle n'est pas autorisée, la réinitialiser
            if ($resource && !in_array($resource->resource_category_id, [2, 3, 4])) {
                return redirect()->route('user.create-reservation')
                    ->with('error', 'Vous n\'avez pas le droit de réserver cet équipement puissant. Seuls les utilisateurs internes peuvent le faire.');
            }
        }

        return view('user.create-reservation', compact('resource', 'resources'));
    }

    /**
     * Enregistre une nouvelle réservation
     */
    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'justification' => 'required|string|min:20|max:1000'
        ]);

        // Vérifier les conflits de réservation
        $conflict = Reservation::where('resource_id', $validated['resource_id'])
            ->whereIn('status', ['EN ATTENTE', 'APPROUVÉE', 'ACTIVE'])
            ->where(function ($query) use ($validated) {
                $query->where('start_date', '<', $validated['end_date'])
                      ->where('end_date', '>', $validated['start_date']);
            })->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'overlap_error' => 'Cette ressource est déjà réservée ou en attente sur cette période.'
            ]);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'EN ATTENTE';

        Reservation::create($validated);

        return redirect()->route('user.dashboard')->with('success', 'Demande de réservation créée avec succès !');
    }

    /**
     * Annule une réservation (seulement si en attente)
     */
    public function cancelReservation(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $reservation->delete();
        return back()->with('success', 'Demande annulée avec succès.');
    }
}
