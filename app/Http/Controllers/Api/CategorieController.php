<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function index()
    {
        // Get categories with the count of their publications
        $categories = Categorie::withCount('publications')->get();

        // Return as a standard JSON response
        return response()->json([
            'data' => $categories
        ], 200);
    }
}
