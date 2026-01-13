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
use App\Models\Reservation; // <-- AJOUTÉ pour le test

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil : modifiée pour afficher les réservations existantes
Route::get('/', function () {
    // On récupère les réservations avec les relations pour éviter les erreurs "null"
    $reservations = Reservation::with(['user', 'resource'])->get();
    
    return view('welcome', compact('reservations')); 
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

// Admin
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::resource('resources', ResourceController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('incidents', IncidentController::class);
});

// Manager
Route::middleware(['auth','role:manager'])->group(function(){
    Route::get('/manager/dashboard', [ManagerController::class,'dashboard'])->name('manager.dashboard');
    Route::resource('resources', ResourceController::class)->only(['index', 'show']);
    Route::resource('reservations', ReservationController::class)->only(['index', 'show']);
    Route::resource('incidents', IncidentController::class)->only(['index', 'show']);
});

// Utilisateur normal
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user/dashboard', [UserController::class,'dashboard'])->name('user.dashboard');
    Route::resource('reservations', ReservationController::class)->only(['index','create','store']);
});