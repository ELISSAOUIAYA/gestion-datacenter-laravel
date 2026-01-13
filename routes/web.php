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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil : Affiche les réservations existantes ET les ressources disponibles
Route::get('/', function () {
    // Récupère les réservations avec relations pour le tableau de test
    $reservations = Reservation::with(['user', 'resource'])->get();
    
    // CORRECTION ICI : On cherche 'available' et non 'actif'
    // On récupère toutes les ressources disponibles pour l'affichage
    $resources = Resource::where('status', 'available')->get(); 
    
    return view('welcome', compact('reservations', 'resources')); 
})->name('welcome');

// =======================
// Routes pour les invités (guest)
// =======================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class,'register']);
    Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class,'login']);
});

// =======================
// Route pour se déconnecter
// =======================
Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

// =======================
// Route pour Home (après login)
// =======================
Route::get('/home', function () {
    return view('home'); 
})->name('home')->middleware('auth');

// =======================
// Routes protégées par rôle
// =======================

// Admin : Accès complet à toutes les ressources
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('resources', ResourceController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('incidents', IncidentController::class);
});

// Manager : Consultation et gestion partielle
Route::middleware(['auth', 'role:manager'])->group(function(){
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::resource('resources', ResourceController::class)->only(['index', 'show']);
    Route::resource('reservations', ReservationController::class)->only(['index', 'show']);
    Route::resource('incidents', IncidentController::class)->only(['index', 'show']);
});

// Utilisateur normal : Peut voir et créer ses réservations
Route::middleware(['auth', 'role:user'])->group(function(){
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::resource('reservations', ReservationController::class)->only(['index', 'create', 'store']);
});