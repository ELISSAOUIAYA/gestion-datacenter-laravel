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
    // 1. On prépare les données en ajoutant manuellement l'ID de l'utilisateur connecté
    $data = $request->all();
    $data['user_id'] = auth()->id(); // C'est cette ligne qui manquait !
    $data['status'] = 'pending'; // On s'assure que le statut est défini par défaut

    // 2. Vérification des conflits (Détail n°1)
    $conflit = Reservation::where('resource_id', $request->resource_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
        })
        ->exists();

    if ($conflit) {
        return back()->with('error', 'Cette machine est déjà réservée pour cette période !');
    }

    // 3. Création avec les données complétées
    Reservation::create($data);

    return redirect()->route('user.dashboard')->with('success', 'Réservation effectuée !');
}

         
           public function update(Request $request, Reservation $reservation)
    {
             $request->validate([
            'status' => 'required|in:pending,approved,rejected',
    ]);

          $oldStatus = $reservation->status;
          $reservation->update($request->all());

          
        if ($oldStatus !== $request->status) {
        $title = "Mise à jour de votre réservation";
        
        if ($request->status == 'approved') {
            $message = "Félicitations ! Votre réservation pour la ressource [{$reservation->resource->name}] a été approuvée.";
        } elseif ($request->status == 'rejected') {
            $message = "Désolé, votre demande pour [{$reservation->resource->name}] a été refusée.";
            $reservation->resource->update(['status' => 'available']);
        }

       
        $reservation->user->addNotification($title, $message);
    }

    return back()->with('success', 'Statut mis à jour et utilisateur notifié.');
}
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Réservation annulée.');
    }
}