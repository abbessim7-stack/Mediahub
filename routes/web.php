<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Storage;
use App\Models\Publication;

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
Route::get('/documents/{publication}', function (Publication $publication) {
    // 1. Check if the user is logged in
    if (!auth()->check()) {
        abort(403, 'Accès non autorisé.');
    }

    // 2. Check if the user is the author OR an admin
    if (auth()->id() !== $publication->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'Vous n\'avez pas la permission de voir ce document.');
    }

    // 3. Serve the file securely from the local (private) disk
    // (Note: We are using 'local' disk here. In a real app, you'd upload private files to the 'local' disk).
    if ($publication->fichier_media) {
        return Storage::disk('public')->download($publication->fichier_media);
    }

    abort(404, 'Aucun fichier associé.');
})->name('documents.secure');
