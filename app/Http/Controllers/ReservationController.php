<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Lister les réservations de l'utilisateur connecté
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user(); 
        $reservations = $user->reservations()->with('resource')->get();
        
        return view('reservations.index', compact('reservations'));
    }

    // Afficher le formulaire de réservation
    public function create(Request $request)
    {
        // PROTECTION : Redirige si l'utilisateur n'est pas connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour réserver.');
        }

        $resourceId = $request->query('resource_id');
        
        // Cas 1 : On vient de l'accueil avec un ID précis
        if ($resourceId) {
            $resource = Resource::findOrFail($resourceId);
            return view('reservations.create', compact('resource'));
        }

        // Cas 2 : On accède au formulaire sans ID (liste des ressources dispos)
        $resources = Resource::where('status', 'available')->get();
        return view('reservations.create', compact('resources'));
    }

    // Enregistrer la réservation (Le cœur du Backend)
    public function store(Request $request)
    {
        // SÉCURITÉ : Protection de la méthode POST
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 1. Validation des données entrantes
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date|after_or_equal:now',
            'end_date'    => 'required|date|after:start_date',
        ]);

        // 2. Vérification du chevauchement (Disponibilité réelle)
        $isTaken = Reservation::where('resource_id', $request->resource_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();

        if ($isTaken) {
            return back()->withErrors(['error' => 'Cette ressource est déjà réservée pour ces dates.']);
        }

        // 3. Création de la réservation
        $reservation = Reservation::create([
            'user_id'     => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'pending', 
        ]);

        // 4. Logique Métier : On marque la ressource comme occupée
        $resource = Resource::find($request->resource_id);
        $resource->update(['status' => 'occupied']);

        return redirect()->route('welcome')->with('success', 'Réservation effectuée avec succès !');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', ['reservation' => $reservation->load('user', 'resource')]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $reservation->update($request->all());

        // Si rejetée, on libère la ressource immédiatement
        if($request->status == 'rejected') {
            $reservation->resource->update(['status' => 'available']);
        }

        return back()->with('success', 'Réservation mise à jour.');
    }

    public function destroy(Reservation $reservation)
    {
        // Libération de la ressource avant suppression
        $reservation->resource->update(['status' => 'available']);
        $reservation->delete();
        
        return redirect()->route('welcome')->with('success', 'Réservation annulée et ressource libérée.');
    }
}