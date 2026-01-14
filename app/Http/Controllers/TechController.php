<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Importation nécessaire
use App\Models\Incident;    // Importation nécessaire

class TechController extends Controller
{
    public function Dashboard() 
    {
        // On récupère les réservations pour le tableau du haut
        $reservations = Reservation::with(['user', 'resource'])->latest()->get(); 
        
        // On récupère les incidents (messages du bouton rouge) pour la modération
        $incidents = Incident::with(['user', 'resource'])->latest()->get(); 

        // On envoie les deux variables à la vue
        return view('responsable.dashboard', compact('reservations', 'incidents'));
    }
}