<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil pour tous (invités et connectés)
Route::get('/', function () {
    return view('welcome'); 
})->name('welcome');

// Routes pour les invités (guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class,'register']);
    Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class,'login']);
});

// Route pour se déconnecter
Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

// Route pour Home (après login)
Route::get('/home', function () {
    return view('home'); // Crée resources/views/home.blade.php
})->name('home')->middleware('auth');

// =======================
// Routes protégées par rôle
// =======================

// Admin
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin', [AdminController::class,'dashboard'])->name('admin.dashboard');
});

// Manager
Route::middleware(['auth','role:manager'])->group(function(){
    Route::get('/manager', [ManagerController::class,'dashboard'])->name('manager.dashboard');
});

// Utilisateur normal
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user', [UserController::class,'dashboard'])->name('user.dashboard');
});

// Route pour se déconnecter
Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

// Route pour Home (après login)
Route::get('/home', function () {
    return view('home'); // Crée resources/views/home.blade.php
})->name('home')->middleware('auth');

// =======================
// Routes protégées par rôle
// =======================

// Admin
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin', [AdminController::class,'dashboard'])->name('admin.dashboard');
});

// Manager
Route::middleware(['auth','role:manager'])->group(function(){
    Route::get('/manager', [ManagerController::class,'dashboard'])->name('manager.dashboard');
});

// Utilisateur normal
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user', [UserController::class,'dashboard'])->name('user.dashboard');
});