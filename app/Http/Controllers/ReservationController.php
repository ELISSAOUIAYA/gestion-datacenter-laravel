<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
   public function index()
{
    $user = Auth::user();

    // On récupère les réservations de l'utilisateur connecté
    $reservations = Reservation::where('user_id', $user->id)
        ->with('resource')
        ->latest()
        ->get();

    // TRÈS IMPORTANT : Le nom de la vue doit être 'user.dashboard' 
    // et on doit passer la variable 'reservations'
    return view('user.dashboard', compact('reservations'));
}
    // 2. Stocker la réservation (Action depuis le bouton "Réserver" de l'accueil)
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            // On peut rendre les dates optionnelles si on veut une réservation immédiate par défaut
            'start_date'  => 'nullable|date|after_or_equal:today',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        // Vérification de sécurité : La ressource est-elle vraiment dispo ?
        $resource = Resource::findOrFail($request->resource_id);
        if ($resource->status !== 'available') {
            return redirect()->back()->with('error', 'Désolé, cette ressource n\'est plus disponible.');
        }

        // Création
        Reservation::create([
            'user_id'     => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date'  => $request->start_date ?? now(),
            'end_date'    => $request->end_date ?? now()->addDays(7),
            'status'      => 'en_attente', // Statut par défaut
        ]);

        return redirect()->route('welcome')->with('success', 'Demande de réservation envoyée avec succès !');
    }

    // 3. Mettre à jour (Utilisé par le Responsable Technique pour Valider/Refuser)
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:en_attente,validée,refusée',
        ]);

        // Si on valide la réservation, on peut changer le statut de la ressource en 'occupied'
        if ($request->status === 'validée') {
            $reservation->resource->update(['status' => 'occupied']);
        } 
        
        // Si on refuse ou qu'on termine, on libère
        if ($request->status === 'refusée') {
            $reservation->resource->update(['status' => 'available']);
        }

        $reservation->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Le statut de la réservation a été mis à jour.');
    }

    // 4. Supprimer/Annuler
    public function destroy(Reservation $reservation)
    {
        // Libérer la ressource si elle était occupée
        $reservation->resource->update(['status' => 'available']);
        
        $reservation->delete();
        return redirect()->back()->with('success', 'Réservation annulée.');
    }

    public function create(Request $request)
   {
    // On récupère l'ID de la ressource depuis l'URL
    $resource = Resource::findOrFail($request->resource_id);

    // On renvoie vers la vue que Chorouk est en train de préparer
    return view('reservations.create', compact('resource'));
   }
}