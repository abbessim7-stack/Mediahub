<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Publication;

class PublicationTest extends TestCase
{
    use RefreshDatabase;

   public function test_un_auteur_peut_modifier_sa_propre_publication(): void
    {
        // 1. Create a category first!
        $categorie = \App\Models\Categorie::create(['nom' => 'Video', 'slug' => 'video']);

        // 2. Create an author and a publication owned by them
        $auteur = User::factory()->create();
        $publication = Publication::factory()->create([
            'user_id' => $auteur->id,
            'categorie_id' => $categorie->id // Use the category we just created
        ]);

        // 3. Act as the author and try to update the publication
        $response = $this->actingAs($auteur)
            ->put("/contenus/{$publication->id}", [
                'titre' => 'Titre modifié par le propriétaire',
                'contenu' => str_repeat('a', 30),
                'categorie_id' => $categorie->id, // Use the valid category ID
            ]);

        $response->assertRedirect("/contenus/{$publication->id}");

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'titre' => 'Titre modifié par le propriétaire'
        ]);
    }

    public function test_un_utilisateur_ne_peut_pas_modifier_la_publication_dun_autre(): void
    {
        // 1. Create a category first!
        $categorie = \App\Models\Categorie::create(['nom' => 'Audio', 'slug' => 'audio']);

        // 2. Create two different users
        $auteur = User::factory()->create();
        $intrus = User::factory()->create();

        // 3. Create a publication owned by the first user
        $publication = Publication::factory()->create([
            'user_id' => $auteur->id,
            'categorie_id' => $categorie->id
        ]);

        // 4. Act as the intruder and try to update the publication
        $response = $this->actingAs($intrus)
            ->put("/contenus/{$publication->id}", [
                'titre' => 'Tentative de piratage',
                'contenu' => str_repeat('a', 30),
                'categorie_id' => $categorie->id,
            ]);

        // 5. Assert the application blocks the action with a 403 Forbidden status
        $response->assertForbidden();
    }
        public function test_creation_publication_avec_image_invalide_est_rejetee(): void
    {
        $auteur = User::factory()->create();
        $categorie = \App\Models\Categorie::create(['nom' => 'Test', 'slug' => 'test']);

        // Create a fake file that is NOT an image
        $fichierInvalide = \Illuminate\Http\UploadedFile::fake()->create('document.txt', 100); // 100KB text file

        $response = $this->actingAs($auteur)
            ->post('/contenus', [
                'titre' => 'Test image invalide',
                'contenu' => str_repeat('a', 30),
                'categorie_id' => $categorie->id,
                'image' => $fichierInvalide, // Send the text file as an image
            ]);

        // Assert that the validation caught the error for the 'image' field
        $response->assertSessionHasErrors('image');

        // Assert nothing was saved in the database
        $this->assertDatabaseMissing('publications', ['titre' => 'Test image invalide']);
    }
}
