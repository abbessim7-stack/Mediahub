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
        $this->authorize('gerer-categories'); // <--- ADD THIS
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(StoreCategorieRequest $request)
    {
        $this->authorize('gerer-categories'); // <--- ADD THIS
        Categorie::create($request->validated());
        return redirect()->route('categories.index')->with('succes', 'Catégorie créée avec succès.');
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
        $this->authorize('gerer-categories'); // <--- ADD THIS
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        $this->authorize('gerer-categories'); // <--- ADD THIS
        $categorie->update($request->validated());
        return redirect()->route('categories.index')->with('succes', 'Catégorie mise à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
       public function destroy(Categorie $categorie)
    {
        $this->authorize('gerer-categories'); // <--- ADD THIS

        if ($categorie->publications()->count() > 0) {
            return redirect()->route('categories.index')->with('erreur', 'Impossible de supprimer cette catégorie car elle contient des publications.');
        }

        $categorie->delete();
        return redirect()->route('categories.index')->with('succes', 'Catégorie supprimée avec succès.');
    }
};
