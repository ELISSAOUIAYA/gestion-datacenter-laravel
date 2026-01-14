<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Afficher le dashboard de l'utilisateur
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('resource')
            ->latest()
            ->get();

        return view('user.dashboard', compact('reservations'));
    }

    // Afficher le formulaire de réservation
    public function create(Request $request)
    {
        // On récupère l'ID de la ressource
        $resourceId = $request->query('resource_id') ?? $request->resource;
        $resource = Resource::findOrFail($resourceId);

        return view('reservations.create', compact('resource'));
    }

    // Enregistrer la réservation (Correction de l'erreur SQL)
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date|after_or_equal:today',
            'end_date'    => 'required|date|after:start_date',
        ]);

        // On utilise 'pending' au lieu de 'en_attente' pour éviter l'erreur de troncature SQL
        Reservation::create([
            'user_id'       => Auth::id(),
            'resource_id'   => $request->resource_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'justification' => $request->justification ?? 'Besoin académique',
            'status'        => 'pending', 
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Demande envoyée avec succès !');
    }

    // Mise à jour du statut par le Responsable Technique
    public function update(Request $request, Reservation $reservation)
{
    $request->validate([
        'status' => 'required|in:approved,rejected', // On attend ces deux valeurs
    ]);

    $reservation->update(['status' => $request->status]);

    return back()->with('success', 'La décision a été enregistrée.');
}
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Réservation annulée.');
    }
}