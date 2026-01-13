<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\IncidentController;
use App\Models\Reservation;
use App\Models\Resource; 

// Page d'accueil : Publique
Route::get('/', function () {
    $reservations = Reservation::with(['user', 'resource'])->get();
    $resources = Resource::where('status', 'available')->get(); 
    return view('welcome', compact('reservations', 'resources')); 
})->name('welcome');

// Authentification pour les Invités
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class,'register']);
    Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class,'login']);
});

// =========================================================
// ROUTES PROTÉGÉES (Connexion Requise)
// =========================================================
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class,'logout'])->name('logout');
    Route::redirect('/home', '/');

    // --- LOGIQUE DE RÉSERVATION PARTAGÉE ---
    // Tout utilisateur connecté peut accéder au formulaire et stocker
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // Admin : Gestion totale
    Route::middleware(['role:admin'])->group(function(){
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('resources', ResourceController::class);
        Route::resource('incidents', IncidentController::class);
        Route::resource('reservations', ReservationController::class)->except(['create', 'store']);
    });

    // Manager : Consultation
    Route::middleware(['role:manager'])->group(function(){
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
        Route::resource('resources', ResourceController::class)->only(['index', 'show']);
        Route::resource('incidents', IncidentController::class)->only(['index', 'show']);
        Route::resource('reservations', ReservationController::class)->only(['index', 'show']);
    });

    // User : Dashboard personnel
    Route::middleware(['role:user'])->group(function(){
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::resource('reservations', ReservationController::class)->only(['index', 'show'])->except(['create', 'store']);
    });
});