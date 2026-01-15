<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResourceController; 
use App\Http\Controllers\ReservationController; 
use App\Http\Controllers\IncidentController;    
use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $reservations = Reservation::with(['user', 'resource'])->get();
    $resources = Resource::with('category')
        ->where('status', 'available')
        ->orderBy('resource_category_id', 'asc')
        ->get();

    return view('welcome', compact('reservations', 'resources')); 
})->name('welcome');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTIFICATION (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

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
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::patch('/admin/resources/{resource}/maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.resources.maintenance');
        Route::resource('resources', ResourceController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 2 : RESPONSABLE TECHNIQUE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Responsable Technique'])->group(function() {
        Route::get('/responsable/dashboard', [TechController::class, 'dashboard'])->name('tech.dashboard');
        
        // Validation des réservations (Action Accepter/Refuser)
      Route::put('/reservations/{reservation}/update', [ReservationController::class, 'update'])->name('reservations.update');
        
        // Gestion des incidents par le manager
        Route::delete('/manager/incidents/{incident}', [IncidentController::class, 'destroy'])->name('manager.incidents.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 3 : UTILISATEUR INTERNE (Toi)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Utilisateur Interne'])->group(function() {
        // Dashboard et Historique
        Route::get('/user/dashboard', [ReservationController::class, 'index'])->name('user.dashboard');
        Route::get('/user/historique', [ReservationController::class, 'historique'])->name('user.historique');

        // Création de réservation
        Route::get('/reservations/create/{resource?}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/valider-reservation', [ReservationController::class, 'store'])->name('reservations.store');

        // Signalement d'incidents
        Route::get('/incidents/report/{resource_id}', [IncidentController::class, 'create'])->name('incidents.create');
        Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');

        // Annulation d'une réservation (Delete)
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

});