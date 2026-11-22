<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_sinscrire(): void
    {
        // Send a POST request to the registration route
        $response = $this->post('/inscription', [
            'name' => 'Amel', // Note: we use 'name' because our database uses 'name'
            'email' => 'amel@exemple.com',
            'password' => 'motdepasse123',
            'password_confirmation' => 'motdepasse123',
        ]);

        // Assert the user is redirected to the home page
        $response->assertRedirect('/');

        // Assert the user is now authenticated (logged in)
        $this->assertAuthenticated();

        // Assert the user exists in the database
        $this->assertDatabaseHas('users', ['email' => 'amel@exemple.com']);
    }

    public function test_connexion_avec_identifiants_incorrects(): void
    {
        // Attempt to log in with an email that doesn't exist
        $response = $this->post('/connexion', [
            'email' => 'inconnu@exemple.com',
            'password' => 'faux_mot_de_passe',
        ]);

        // Assert that the session has an error for the 'email' field
        $response->assertSessionHasErrors('email');

        // Assert that the user remains a guest (not logged in)
        $this->assertGuest();
    }
}
