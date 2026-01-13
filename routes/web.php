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

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

Route::get('/home', function () {
    return view('home'); 
})->name('home')->middleware('auth');

/*
|--------------------------------------------------------------------------
| 2. ROUTES PROTÉGÉES (COMMUNES)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Formulaire de réservation (Chorouk)
    Route::get('/reservations/create/{resource}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    
    // Signalement d'incident (Accessible par Utilisateur et Tech)
    Route::get('/incidents/report/{resource_id}', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
});

/*
|--------------------------------------------------------------------------
| 3. DASHBOARD ADMINISTRATEUR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
    Route::patch('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
    Route::patch('/admin/resources/{resource}/maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.resources.maintenance');
});

/*
|--------------------------------------------------------------------------
| 4. DASHBOARD RESPONSABLE TECHNIQUE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Responsable Technique'])->group(function(){
    Route::get('/responsable/dashboard', [TechController::class, 'dashboard'])->name('tech.dashboard');
    Route::put('/reservations/{reservation}/update', [ReservationController::class, 'update'])->name('reservations.update');
    
    // Ressources CRUD pour le Tech
    Route::resource('resources', ResourceController::class)->only(['index', 'show']);
    Route::resource('incidents', IncidentController::class)->except(['create', 'store']);
});

/*
|--------------------------------------------------------------------------
| 5. DASHBOARD UTILISATEUR INTERNE (Ingénieur / Enseignant / Doctorant)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Utilisateur Interne'])->group(function () {
    // On utilise UserController@dashboard pour l'historique et les filtres
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});