<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResourceController;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES (Accessibles à l'INVITÉ)
|--------------------------------------------------------------------------
*/

// Page d'accueil (Landing Page) visible par tous dès l'arrivée
Route::get('/', function () {
    return view('welcome'); 
})->name('welcome');

// Catalogue des ressources (Lecture seule pour l'invité - Règle n°1 du sujet)
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');


/*
|--------------------------------------------------------------------------
| 2. AUTHENTIFICATION (Login / Inscription)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| 3. ROUTES PROTÉGÉES PAR RÔLES (Connexion obligatoire)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Redirection de secours
    Route::get('/home', function () {
        return view('home'); 
    })->name('home');

    // --- TYPE 4 : ADMINISTRATEUR ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    });

    // --- TYPE 3 : RESPONSABLE TECHNIQUE ---
    Route::middleware(['auth', 'role:Responsable Technique'])->group(function () {
    Route::get('/responsable/dashboard', [TechController::class, 'dashboard'])->name('tech.dashboard');
    });
    
    // --- TYPE 2 : UTILISATEUR INTERNE ---
    Route::middleware(['role:Utilisateur Interne'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });

});