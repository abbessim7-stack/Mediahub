<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Publication;
use App\Models\Categorie;

class PublicationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_liste_des_publications_via_api(): void
    {
        // 1. Create a category so the factory doesn't fail
        $categorie = Categorie::create(['nom' => 'Video', 'slug' => 'video']);

        // 2. Create 5 fake publications
        Publication::factory()->count(5)->create(['categorie_id' => $categorie->id]);

        // 3. Call the API endpoint
        $response = $this->getJson('/api/publications');

        // 4. Assert a 200 OK and that the JSON has exactly 5 items in the 'data' array
        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    public function test_creation_sans_jeton_est_refusee(): void
    {
        // 1. Try to create a publication WITHOUT providing a Bearer token
        // Note: We use postJson() instead of post() so Laravel returns JSON errors, not redirects.
        $response = $this->postJson('/api/publications', [
            'titre' => 'Test sans token',
            'contenu' => 'Ceci ne devrait pas fonctionner.',
            'categorie_id' => 1, // Even if this ID is wrong, it should fail at 401 first
        ]);

        // 2. Assert that the API returns 401 Unauthorized
        $response->assertStatus(401);
    }
}
