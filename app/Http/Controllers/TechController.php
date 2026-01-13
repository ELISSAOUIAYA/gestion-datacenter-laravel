<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 

class TechController extends Controller 
{
    public function dashboard()
    {
        // 1. Récupérer toutes les réservations avec les infos du User et de la Ressource
        // On utilise 'with' pour éviter de ralentir le serveur (Eager Loading)
        $reservations = Reservation::with(['user', 'resource'])->latest()->get();

        // 2. Envoyer la variable à la vue
        return view('responsable.dashboard', compact('reservations'));
    }
}