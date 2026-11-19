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
        public function store(StorePublicationRequest $request) // <--- CHANGED
    {
        // Get the validated data
        $data = $request->validated();

        // Force the user_id (temporary until Week 8)
        $data['user_id'] = 1;

        Publication::create($data);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdatePublicationRequest $request, Publication $contenu) // <--- CHANGED
    {
        $contenu->update($request->validated()); // <--- CHANGED

        return redirect()->route('contenus.index')
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
