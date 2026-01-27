<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Importation nécessaire
use App\Models\Incident;    // Importation nécessaire
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class TechController extends Controller
{
    public function dashboard() 
    {
        // Récupérer les ressources supervisées par le responsable
        $supervisedResourceIds = Auth::user()->supervises()->pluck('id')->toArray();
        
        // On récupère les réservations pour les ressources supervisées
        $reservations = Reservation::whereIn('resource_id', $supervisedResourceIds)
            ->with(['user', 'resource'])
            ->latest()
            ->get();
        
        // On récupère les incidents pour les ressources supervisées
        $incidents = Incident::whereIn('resource_id', $supervisedResourceIds)
            ->with(['user', 'resource'])
            ->latest()
            ->get();

        // On récupère les ressources supervisées
        $resources = Auth::user()->supervises()->with('category')->get();

        // On envoie les trois variables à la vue
        return view('responsable.dashboard', compact('reservations', 'incidents', 'resources'));
    }
}