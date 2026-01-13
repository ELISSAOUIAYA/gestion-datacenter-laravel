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
        $user = Auth::user(); // Récupérer l'utilisateur connecté
        $reservations = $user->reservations()->with('resource')->get();
        return response()->json($reservations);
    }

    // Formulaire création (liste ressources)
    public function create()
    {
        $resources = Resource::all();
        return response()->json($resources);
    }

    // Stocker réservation
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $reservation = Reservation::create([
            'user_id'     => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        return response()->json($reservation, 201);
    }

    // Afficher réservation
    public function show(Reservation $reservation)
    {
        return response()->json($reservation->load('user', 'resource'));
    }

    // Formulaire édition
    public function edit(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    // Mettre à jour
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'start_date' => 'sometimes|required|date',
            'end_date'   => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    // Supprimer
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted']);
    }
}
