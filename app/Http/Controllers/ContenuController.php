<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Models\Categorie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Image;
use App\Events\PublicationCreee;

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
        $donnees = $request->validated();

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')->store('publications', 'public');
        }

        if ($request->hasFile('fichier_media')) {
            $fichier = $request->file('fichier_media');
            $donnees['fichier_media'] = $fichier->store('medias', 'public');
            $donnees['type_media'] = str_starts_with($fichier->getMimeType(), 'audio') ? 'audio' : 'video';
        }

        $donnees['user_id'] = auth()->id();

        $publication = Publication::create($donnees);

        // TRIGGER THE EVENT HERE
        event(new PublicationCreee($publication));

        return redirect()->route('contenus.index')
            ->with('succes', 'Publication créée avec succès.');
    }
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
        $this->authorize('update', $contenu);

        $donnees = $request->validated();

        // 1. Handle Image Replacement
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($contenu->image) {
                Storage::disk('public')->delete($contenu->image);
            }
            // Store the new image
            $donnees['image'] = $request->file('image')->store('publications', 'public');
        }

        // 2. Handle Media Replacement
        if ($request->hasFile('fichier_media')) {
            // Delete the old media if it exists
            if ($contenu->fichier_media) {
                Storage::disk('public')->delete($contenu->fichier_media);
            }
            // Store the new media
            $fichier = $request->file('fichier_media');
            $donnees['fichier_media'] = $fichier->store('medias', 'public');

            // Update the media type
            $donnees['type_media'] = str_starts_with($fichier->getMimeType(), 'audio') ? 'audio' : 'video';
        }

        // 3. Update the publication
        $contenu->update($donnees);

        return redirect()->route('contenus.show', $contenu)
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
