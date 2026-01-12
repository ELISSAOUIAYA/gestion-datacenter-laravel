<?
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome'); // page d’accueil invités
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routes pour invités
Route::middleware('guest')->group(function () {
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class,'showRegistrationForm']);
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class,'register']);
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm']);
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class,'login']);
});

