<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CategorieTest extends TestCase
{
    // This trait resets the database for every single test
    use RefreshDatabase;

    public function test_creation_dune_categorie_par_un_admin(): void
    {
        // 1. Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // 2. Act as this admin and send a POST request to create a category
        $response = $this->actingAs($admin)->post('/categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        // 3. Assert that the user is redirected to the categories list
        $response->assertRedirect('/categories');

        // 4. Assert that the category was actually saved in the database
        $this->assertDatabaseHas('categories', [
            'slug' => 'podcast',
        ]);
    }
}
