<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AuthController;

// Page d'accueil
Route::get('/', [PageController::class, 'accueil'])->name('accueil');

// Page à propos
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');

// Routes d'administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])->name('dashboard');
});

// Routes CRUD des catégories
Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);

// ==========================================
// PROTECTED ROUTES (Logged-in users only)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'deconnecter'])->name('deconnexion');

    // PUT THIS FIRST so 'create' is matched before 'show'
    Route::resource('contenus', ContenuController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// ==========================================
// PUBLIC ROUTES (Anyone can see)
// ==========================================
// whereNumber('contenu') ensures the ID is a number, not the word 'create'
Route::resource('contenus', ContenuController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy'])
    ->whereNumber('contenu');

// ==========================================
// AUTHENTICATION ROUTES (Guests only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'create'])->name('inscription');
    Route::post('/inscription', [AuthController::class, 'store']);

    Route::get('/login', [AuthController::class, 'creerConnexion'])->name('login');
    Route::get('/connexion', [AuthController::class, 'creerConnexion'])->name('connexion');
    Route::post('/connexion', [AuthController::class, 'connecter']);
});
