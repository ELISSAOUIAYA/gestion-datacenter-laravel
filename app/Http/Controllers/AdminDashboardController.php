<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\Reservation;
use App\Models\MaintenancePeriod;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

   /**
     * 1. TABLEAU DE BORD ADMINISTRATEUR
     */
    public function dashboard()
    {
        // On récupère le nombre total de ressources une seule fois pour optimiser
        $totalResourcesCount = Resource::count();

        // LOGIQUE : On compte les ressources uniques qui possèdent au moins une réservation 'VALIDÉE'
        // Cela permet d'afficher un taux d'occupation dès qu'un administrateur approuve une demande.
        $occupiedResourcesCount = Resource::whereHas('reservations', function($query) {
            $query->where('status', 'VALIDÉE');
        })->count();

        // Statistiques globales pour les cartes du haut
        $stats = [
            'total_users' => User::count(),
            'total_resources' => $totalResourcesCount,
            // Calcul du taux : (Ressources réservées / Total ressources) * 100
            'occupied_rate' => $totalResourcesCount > 0 
                ? round(($occupiedResourcesCount / $totalResourcesCount) * 100) 
                : 0,
            'maintenance_count' => Resource::where('status', 'maintenance')->count(),
        ];
        
        // Récupération des données pour les tableaux de la vue
        $users = User::with('role')->get();
        $resources = Resource::with('category')->get();
        $roles = Role::all();
        $categories = ResourceCategory::all();
        
        // On récupère les maintenances à venir ou en cours
        $maintenances = MaintenancePeriod::with('resource')
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        // Retourne la vue avec toutes les données compactées
        return view('admin.dashboard', compact(
            'stats', 
            'users', 
            'resources', 
            'roles', 
            'categories', 
            'maintenances'
        ));
    }
    /**
     * 2. GESTION UTILISATEURS - Liste
     */
    public function users(Request $request)
    {
        $query = User::with('role');

        // Filtrage
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->whereHas('role', function($q) {
                $q->where('name', request('role'));
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? true : false);
        }

        $users = $query->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * 2. GESTION UTILISATEURS - Détails
     */
    public function userShow(User $user)
    {
        $user->load(['role', 'reservations']);
        $roles = Role::all();

        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * 2. GESTION UTILISATEURS - Mise à jour
     */
    public function userUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required|boolean'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Utilisateur mis à jour');
    }

    /**
     * 2. GESTION UTILISATEURS - Activation/Désactivation
     */
    public function userToggle(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Utilisateur {$status}");
    }

    /**
     * 2. GESTION UTILISATEURS - Suppression
     */
    public function userDestroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé');
    }

    /**
     * 3. GESTION RESSOURCES - Liste
     */
    public function resources(Request $request)
    {
        $query = Resource::with(['category', 'techManager']);

        // Filtrage
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('resource_category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('active')) {
            $query->where('is_active', $request->active === 'active' ? true : false);
        }

        $resources = $query->paginate(15);
        $categories = ResourceCategory::all();

        return view('admin.resources.index', compact('resources', 'categories'));
    }

    /**
     * 3. GESTION RESSOURCES - Détails
     */
    public function resourceShow(Resource $resource)
    {
        $resource->load(['category', 'techManager', 'reservations']);
        $categories = ResourceCategory::all();
        $techManagers = User::whereHas('role', function($q) {
            $q->where('name', 'Responsable Technique');
        })->get();

        return view('admin.resources.show', compact('resource', 'categories', 'techManagers'));
    }

    /**
     * 3. GESTION RESSOURCES - Mise à jour
     */
    public function resourceUpdate(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_category_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'bandwidth' => 'nullable|string',
            'capacity' => 'nullable|string',
            'os' => 'nullable|string',
            'tech_manager_id' => 'nullable|exists:users,id',
            'is_active' => 'required|boolean'
        ]);

        $resource->update($validated);

        return redirect()->route('admin.resources.show', $resource)->with('success', 'Ressource mise à jour');
    }

    /**
     * 3. GESTION RESSOURCES - Activation/Désactivation
     */
    public function resourceToggle(Resource $resource)
    {
        $resource->is_active = !$resource->is_active;
        $resource->save();

        $status = $resource->is_active ? 'activée' : 'désactivée';
        return back()->with('success', "Ressource {$status}");
    }

    /**
     * 3. GESTION RESSOURCES - Suppression
     */
    public function resourceDestroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('admin.resources.index')->with('success', 'Ressource supprimée');
    }

    /**
     * 3. GESTION CATÉGORIES - Liste
     */
    public function categories()
    {
        $categories = ResourceCategory::withCount('resources')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * 3. GESTION CATÉGORIES - Création
     */
    public function categoryCreate()
    {
        return view('admin.categories.create');
    }

    /**
     * 3. GESTION CATÉGORIES - Stockage
     */
    public function categoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:resource_categories|max:100',
            'description' => 'nullable|string'
        ]);

        ResourceCategory::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée');
    }

    /**
     * 3. GESTION CATÉGORIES - Édition
     */
    public function categoryEdit(ResourceCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * 3. GESTION CATÉGORIES - Mise à jour
     */
    public function categoryUpdate(Request $request, ResourceCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:resource_categories,name,' . $category->id . '|max:100',
            'description' => 'nullable|string'
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour');
    }

    /**
     * 3. GESTION CATÉGORIES - Suppression
     */
    public function categoryDestroy(ResourceCategory $category)
    {
        if ($category->resources()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie avec des ressources');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée');
    }

    /**
     * 4. STATISTIQUES ADMINISTRATEUR
     */
    /**
 * 4. STATISTIQUES GLOBALES (Version Logique 720h)
 */
public function statistics()
{
    // 1. Répartition des utilisateurs par rôle
    $usersByRole = User::select('role_id')
        ->with('role')
        ->get()
        ->groupBy('role_id')
        ->map->count();

    // 2. Évolution des réservations par mois
    $reservationsByMonth = Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->get();

    // 3. CALCUL DE L'INTENSITÉ (Logique 720h)
    // On récupère les ressources avec leurs réservations déjà filtrées sur 'VALIDÉE'
    $resourceOccupancy = Resource::with(['reservations' => function($q) {
        $q->where('status', 'VALIDÉE');
    }])->get()->map(function($r) {
        $totalHours = 0;
        
        // On compte le nombre de réservations validées pour l'affichage
        $validatedCount = $r->reservations->count();

        foreach($r->reservations as $res) {
            // Calcule la durée réelle entre le début et la fin
            // Nécessite que start_date et end_date soient castés en datetime dans le modèle Reservation
            $totalHours += $res->start_date->diffInHours($res->end_date);
        }

        // Calcul du % basé sur un mois standard de 720 heures (30 jours * 24h)
        // min(100, ...) empêche de dépasser les 100% si la réservation est très longue
        $occupancy = $totalHours > 0 ? min(100, round(($totalHours / 720) * 100)) : 0;

        return [
            'name' => $r->name,
            'occupancy' => $occupancy,
            'reservations_count' => $validatedCount
        ];
    });

    // 4. Compteurs pour les cartes de résumé (Top Cards)
    $totalReservations = Reservation::count();
    $activeReservations = Reservation::where('status', 'VALIDÉE')->count();
    $pendingReservations = Reservation::where('status', 'EN ATTENTE')->count();
    $rejectedReservations = Reservation::where('status', 'REFUSÉE')->count();

    // 5. Envoi des données à la vue
    return view('admin.statistics', compact(
        'usersByRole', 
        'reservationsByMonth', 
        'resourceOccupancy',
        'totalReservations', 
        'activeReservations', 
        'pendingReservations', 
        'rejectedReservations'
    ));
}



    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Liste
     */
    public function maintenances()
    {
        $maintenances = MaintenancePeriod::with('resource')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.maintenances.index', compact('maintenances'));
    }

    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Création
     */
    public function maintenanceCreate()
    {
        $resources = Resource::where('is_active', true)->get();

        return view('admin.maintenances.create', compact('resources'));
    }

    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Stockage
     */
    public function maintenanceStore(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string'
        ]);

        MaintenancePeriod::create($validated);

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance planifiée');
    }

    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Édition
     */
    public function maintenanceEdit(MaintenancePeriod $maintenance)
    {
        $resources = Resource::where('is_active', true)->get();

        return view('admin.maintenances.edit', compact('maintenance', 'resources'));
    }

    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Mise à jour
     */
    public function maintenanceUpdate(Request $request, MaintenancePeriod $maintenance)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string'
        ]);

        $maintenance->update($validated);

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance mise à jour');
    }

    /**
     * 5. GESTION MAINTENANCES PLANIFIÉES - Suppression
     */
    public function maintenanceDestroy(MaintenancePeriod $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance supprimée');
    }
}
