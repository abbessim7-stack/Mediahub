<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;

// Page d'accueil
Route::get('/', [PageController::class, 'accueil'])->name('accueil');

// Toutes les routes CRUD pour les contenus
Route::resource('contenus', ContenuController::class);
// Toutes les routes CRUD pour les catégories
Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);

// Page à propos
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');

// Routes d'administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])->name('dashboard');
});
