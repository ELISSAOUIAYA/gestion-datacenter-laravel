<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Lister toutes les réservations pour l'utilisateur connecté
    public function index()
    {
        $user = Auth::user(); 
        // Récupère les réservations de l'utilisateur avec le nom de la ressource
        $reservations = $user->reservations()->with('resource')->get();
        return response()->json($reservations);
    }

    // Formulaire création (uniquement les ressources qui sont actives/disponibles)
    public function create()
    {
        $resources = Resource::where('status', 'actif')->get();
        return response()->json($resources);
    }

    // Stocker réservation
    public function store(Request $request)
    {
        // 1. Validation des données entrantes
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date|after_or_equal:today',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        // 2. Vérification de la disponibilité (Éviter les chevauchements)
        $isTaken = Reservation::where('resource_id', $request->resource_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();

        if ($isTaken) {
            return response()->json([
                'error' => 'Cette ressource est déjà réservée pour les dates sélectionnées.'
            ], 422);
        }

        // 3. Création de la réservation
        $reservation = Reservation::create([
            'user_id'     => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'pending', // On utilise le statut de ton ENUM
        ]);

        return response()->json([
            'message' => 'Réservation effectuée avec succès',
            'data' => $reservation
        ], 201);
    }

    // Afficher les détails d'une réservation précise
    public function show(Reservation $reservation)
    {
        // On charge les relations pour avoir les noms au lieu des simples ID
        return response()->json($reservation->load('user', 'resource'));
    }

    // Formulaire édition
    public function edit(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    // Mettre à jour (utile pour l'admin ou le manager pour changer le statut)
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'start_date' => 'sometimes|required|date',
            'end_date'   => 'sometimes|required|date|after_or_equal:start_date',
            'status'     => 'sometimes|in:pending,approved,rejected', // Liste de ton ENUM
        ]);

        $reservation->update($request->all());
        return response()->json([
            'message' => 'Réservation mise à jour',
            'data' => $reservation
        ]);
    }

    // Supprimer
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(['message' => 'Réservation annulée avec succès']);
    }
}