<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;
Route::get('/categories', [CategorieController::class, 'index']);

// Public API routes (Anyone can read)
Route::apiResource('publications', PublicationController::class)
    ->only(['index', 'show']);
Route::post('/connexion', [AuthController::class, 'connecter']);
// Protected API routes (Requires a valid Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('publications', PublicationController::class)
        ->except(['index', 'show']);
});
