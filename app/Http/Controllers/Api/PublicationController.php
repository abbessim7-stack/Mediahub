<?php

namespace App\Http\Controllers\Api;
use App\Models\Publication;
use App\Http\Resources\PublicationResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function index(Request $request)
    {
        // Start building the query
        $query = Publication::with(['categorie', 'auteur'])->latest();

        // If a category_id is provided in the URL (e.g., ?categorie_id=9), filter by it
        if ($request->has('categorie_id')) {
            $query->where('categorie_id', $request->input('categorie_id'));
        }

        // Paginate the results
        $publications = $query->paginate(10);

        return PublicationResource::collection($publications);
    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(StorePublicationRequest $request)
    {
        // We reuse the Form Request from Week 7!
        $publication = Publication::create([
            ...$request->validated(),
            'user_id' => $request->user()->id, // Uses the authenticated API user
        ]);

        // Return the resource with a 201 Created status code
        return (new PublicationResource($publication))
            ->response()
            ->setStatusCode(201);
    }


    /**
     * Display the specified resource.
     */
   public function show(Publication $publication)
    {
        // Load relations for the single publication
        $publication->load(['categorie', 'auteur']);

        // Return the formatted JSON
        return new PublicationResource($publication);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        // We reuse the Policy from Week 8!
        $this->authorize('update', $publication);

        $publication->update($request->validated());

        return new PublicationResource($publication);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        // We reuse the Policy from Week 8!
        $this->authorize('delete', $publication);

        $publication->delete();

        // Return 204 No Content (standard for successful deletion)
        return response()->json(null, 204);
    }
}
