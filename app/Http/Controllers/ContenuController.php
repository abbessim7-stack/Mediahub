<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Models\Categorie;

use Illuminate\Http\Request;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $publications = Publication::with(['categorie', 'auteur'])
                    ->withCount('commentaires')
                    ->latest()
                    ->paginate(9);

    return view('contenus.index', ['publications' => $publications]);
}

    public function create()
{
    $categories = Categorie::all();
    return view('contenus.create', compact('categories'));
}

    /**
     * Store a newly created resource in storage.
     */
         public function store(StorePublicationRequest $request)
    {
        // Create the publication using validated data and the real logged-in user's ID
        Publication::create([
            ...$request->validated(),
            'user_id' => auth()->id(), // <--- REPLACED THE FAKE '1'
        ]);

        return redirect()->route('contenus.index')
            ->with('succes', 'Publication créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $contenu)
{
   $contenu->load(['categorie', 'auteur', 'commentaires.auteur', 'tags']);
    return view('contenus.show', ['publication' => $contenu]);
}

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Publication $contenu)
    {
        // Check if the user can update this publication
        $this->authorize('update', $contenu);

        $categories = Categorie::all();
        return view('contenus.edit', compact('contenu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdatePublicationRequest $request, Publication $contenu)
    {
        // Check if the user can update this publication
        $this->authorize('update', $contenu);

        $contenu->update($request->validated());

        return redirect()->route('contenus.index')
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Publication $contenu)
    {
        // Check if the user can delete this publication
        $this->authorize('delete', $contenu);

        $contenu->delete();

        return redirect()->route('contenus.index')
            ->with('succes', 'Publication supprimée avec succès.');
    }
}
