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

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $reservations = Reservation::with(['user', 'resource'])->get();
    $resources = Resource::where('status', 'available')->get(); 
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

    Route::post('/logout', [LoginController::class,'logout'])->name('logout');
    Route::redirect('/home', '/'); // Redirige /home vers l'accueil

    // --- LOGIQUE DE RÉSERVATION (Chorouk + Toi) ---
    // On permet de passer l'ID de la ressource ou d'arriver sur un formulaire vide
    Route::get('/reservations/create/{resource?}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // --- LOGIQUE D'INCIDENTS ---
    Route::get('/incidents/report/{resource_id}', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');

    /*
    |--------------------------------------------------------------------------
    | TYPE 1 : ADMINISTRATEUR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gestion des utilisateurs et maintenance
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::patch('/admin/resources/{resource}/maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.resources.maintenance');
        
        // CRUD Complet
        Route::resource('resources', ResourceController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 2 : RESPONSABLE TECHNIQUE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Responsable Technique'])->group(function(){
        Route::get('/responsable/dashboard', [TechController::class, 'dashboard'])->name('tech.dashboard');
        
        // Validation des réservations
        Route::put('/reservations/{reservation}/update', [ReservationController::class, 'update'])->name('reservations.update');
        
        // Consultation incidents
        Route::resource('incidents', IncidentController::class)->except(['create', 'store']);
        Route::delete('/manager/incidents/{incident}', [IncidentController::class, 'destroy'])->name('manager.incidents.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | TYPE 3 : UTILISATEUR INTERNE (Toi)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Utilisateur Interne'])->group(function(){
        // Ton Dashboard avec historique et filtres
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });

});