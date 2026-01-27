<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceManagerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\UserDashboardController;    
use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Page d'accueil pour visiteurs/invités
Route::get('/', function () {
    $resources = \App\Models\Resource::where('status', 'available')
        ->with('category')
        ->orderBy('resource_category_id')
        ->get();
    
    return view('welcome', compact('resources'));
})->name('welcome');

// Consultation des ressources (invités)
Route::get('/resources', function () {
    $categories = \App\Models\ResourceCategory::all();
    $resources = \App\Models\Resource::where('status', 'available')
        ->with('category')
        ->orderBy('resource_category_id')
        ->get();

    // Appliquer les filtres si présents
    if (request('search')) {
        $resources = $resources->filter(function($r) {
            return stripos($r->name, request('search')) !== false;
        });
    }
    if (request('category') && request('category') != '') {
        $resources = $resources->filter(function($r) {
            return $r->resource_category_id == request('category');
        });
    }
    if (request('status') && request('status') != '') {
        $resources = $resources->filter(function($r) {
            return $r->status == request('status');
        });
    }

    return view('guest.resources', compact('categories', 'resources'));
})->name('guest.resources');

// Formulaire de demande d'ouverture de compte
Route::get('/account-request', [AccountRequestController::class, 'create'])->name('guest.account-request.create');
Route::post('/account-request', [AccountRequestController::class, 'store'])->name('guest.account-request.store');

// Routes d'authentification
Auth::routes();

/*
|--------------------------------------------------------------------------
| 3. ROUTES PROTÉGÉES (CONNEXION REQUISE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::redirect('/home', '/');

    // --- NOTIFICATIONS ---
    Route::post('/mark-notifications-read', function () {
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    })->name('notifications.markRead');

    /*
    |--------------------------------------------------------------------------
    | TYPE 1 : ADMINISTRATEUR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::patch('/admin/resources/{resource}/maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.resources.maintenance');
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 2 : RESPONSABLE TECHNIQUE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Responsable Technique'])->group(function() {
        Route::get('/responsable/dashboard', [TechController::class, 'dashboard'])->name('tech.dashboard');
        
        // Gestion des ressources supervisées
        Route::get('/responsable/resources', [ResourceManagerController::class, 'index'])->name('tech.resources.index');
        Route::get('/responsable/resources/create', [ResourceManagerController::class, 'create'])->name('tech.resources.create');
        Route::post('/responsable/resources', [ResourceManagerController::class, 'store'])->name('tech.resources.store');
        Route::get('/responsable/resources/{resource}/edit', [ResourceManagerController::class, 'edit'])->name('tech.resources.edit');
        Route::put('/responsable/resources/{resource}', [ResourceManagerController::class, 'update'])->name('tech.resources.update');
        Route::patch('/responsable/resources/{resource}/maintenance', [ResourceManagerController::class, 'toggleMaintenance'])->name('tech.resources.toggleMaintenance');
        Route::patch('/responsable/resources/{resource}/deactivate', [ResourceManagerController::class, 'deactivate'])->name('tech.resources.deactivate');
        Route::patch('/responsable/resources/{resource}/activate', [ResourceManagerController::class, 'activate'])->name('tech.resources.activate');
        Route::delete('/responsable/resources/{resource}', [ResourceManagerController::class, 'destroy'])->name('tech.resources.destroy');
        
        // Validation des réservations (Action Accepter/Refuser)
        Route::put('/reservations/{reservation}/update', [ReservationController::class, 'update'])->name('reservations.update');
        
        // Gestion des incidents par le manager
        Route::delete('/manager/incidents/{incident}', [IncidentController::class, 'destroy'])->name('manager.incidents.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 3 : UTILISATEUR INTERNE ET UTILISATEUR NORMAL
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Utilisateur Interne|Utilisateur Normal'])->group(function() {
        // Dashboard - Espace personnel
        Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
        
        // Historique des réservations avec filtres
        Route::get('/user/history', [UserDashboardController::class, 'history'])->name('user.history');
        
        // Création de réservation
        Route::get('/user/create-reservation', [UserDashboardController::class, 'createReservation'])->name('user.create-reservation');
        Route::get('/user/create-reservation/{resource}', [UserDashboardController::class, 'createReservation'])->name('user.create-reservation-with-resource');
        Route::post('/user/store-reservation', [UserDashboardController::class, 'storeReservation'])->name('user.store-reservation');
        
        // Annulation d'une réservation (seulement si EN ATTENTE)
        Route::delete('/user/cancel-reservation/{reservation}', [UserDashboardController::class, 'cancelReservation'])->name('user.cancel-reservation');

        // Signalement d'incidents
        Route::get('/incidents/report/{resource_id}', [IncidentController::class, 'create'])->name('incidents.create');
        Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTION ADMIN - DEMANDES DE COMPTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('/admin/account-requests')->middleware(['role:Admin'])->group(function() {
        Route::get('/', [AccountRequestController::class, 'index'])->name('admin.account-requests.index');
        Route::get('/{accountRequest}', [AccountRequestController::class, 'show'])->name('admin.account-requests.show');
        Route::post('/{accountRequest}/approve', [AccountRequestController::class, 'approve'])->name('admin.account-requests.approve');
        Route::post('/{accountRequest}/reject', [AccountRequestController::class, 'reject'])->name('admin.account-requests.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTION ADMIN COMPLÈTE - ADMINISTRATEUR DATA CENTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('/admin')->middleware(['role:Admin'])->group(function() {
        // Tableau de bord
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

        // Gestion des utilisateurs
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users.index');
        Route::get('/users/{user}', [AdminDashboardController::class, 'userShow'])->name('admin.users.show');
        Route::put('/users/{user}', [AdminDashboardController::class, 'userUpdate'])->name('admin.users.update');
        Route::post('/users/{user}/toggle', [AdminDashboardController::class, 'userToggle'])->name('admin.dashboard.users.toggle');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'userDestroy'])->name('admin.users.destroy');

        // Gestion des ressources
        Route::get('/resources', [AdminDashboardController::class, 'resources'])->name('admin.resources.index');
        Route::get('/resources/{resource}', [AdminDashboardController::class, 'resourceShow'])->name('admin.resources.show');
        Route::put('/resources/{resource}', [AdminDashboardController::class, 'resourceUpdate'])->name('admin.resources.update');
        Route::post('/resources/{resource}/toggle', [AdminDashboardController::class, 'resourceToggle'])->name('admin.resources.toggle');
        Route::delete('/resources/{resource}', [AdminDashboardController::class, 'resourceDestroy'])->name('admin.resources.destroy');

        // Gestion des catégories
        Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminDashboardController::class, 'categoryCreate'])->name('admin.categories.create');
        Route::post('/categories', [AdminDashboardController::class, 'categoryStore'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [AdminDashboardController::class, 'categoryEdit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [AdminDashboardController::class, 'categoryUpdate'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [AdminDashboardController::class, 'categoryDestroy'])->name('admin.categories.destroy');

        // Statistiques globales
        Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('admin.statistics');

        // Gestion des maintenances planifiées
        Route::get('/maintenances', [AdminDashboardController::class, 'maintenances'])->name('admin.maintenances.index');
        Route::get('/maintenances/create', [AdminDashboardController::class, 'maintenanceCreate'])->name('admin.maintenances.create');
        Route::post('/maintenances', [AdminDashboardController::class, 'maintenanceStore'])->name('admin.maintenances.store');
        Route::get('/maintenances/{maintenance}/edit', [AdminDashboardController::class, 'maintenanceEdit'])->name('admin.maintenances.edit');
        Route::put('/maintenances/{maintenance}', [AdminDashboardController::class, 'maintenanceUpdate'])->name('admin.maintenances.update');
        Route::delete('/maintenances/{maintenance}', [AdminDashboardController::class, 'maintenanceDestroy'])->name('admin.maintenances.destroy');
    });

});