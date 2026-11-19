<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::withCount('publications')->paginate(5);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(StoreCategorieRequest $request) // <--- CHANGED
    {
        Categorie::create($request->validated()); // <--- CHANGED

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        // Not required for this week, but you can add it later
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie) // <--- CHANGED
    {
        $categorie->update($request->validated()); // <--- CHANGED

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie supprimée avec succès.');
    }
}
