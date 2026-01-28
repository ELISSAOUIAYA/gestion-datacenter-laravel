<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\Role;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function dashboard()
{
    // 1. Statistiques globales
    $totalResources = Resource::count();

    // On compte toutes les ressources qui ont AU MOINS une réservation validée
    // On ignore l'heure pour être sûr que ça s'affiche même si les fuseaux horaires divergent
    $occupiedResourcesCount = Resource::whereHas('reservations', function($query) {
        $query->where('status', 'VALIDÉE');
    })->count();
   
    $stats = [
        'total_users' => User::count(),
        'total_resources' => $totalResources,
        'occupied_rate' => $totalResources > 0 ? round(($occupiedResourcesCount / $totalResources) * 100) : 0,
        'maintenance_count' => Resource::where('status', 'maintenance')->count(),
    ];

    // 2. Données pour les tableaux
    $users = User::with('role')->get();
    $resources = Resource::with('category')->get();
    $roles = Role::all();

    return view('admin.dashboard', compact('stats', 'users', 'resources', 'roles'));
}
    // Gérer le rôle d'un utilisateur (ex: pour corriger le compte d'AYA)
    public function updateRole(Request $request, User $user)
    {
        $user->update(['role_id' => $request->role_id]);
        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    // Activer ou Désactiver un compte
    public function toggleUserStatus(User $user)
    {
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();
        return back()->with('success', 'Statut du compte modifié.');
    }

    // Mettre un serveur en maintenance planifiée
    public function toggleMaintenance(Resource $resource)
    {
        $resource->status = ($resource->status === 'maintenance') ? 'available' : 'maintenance';
        $resource->save();
        return back()->with('success', 'État de maintenance mis à jour.');
    }
}