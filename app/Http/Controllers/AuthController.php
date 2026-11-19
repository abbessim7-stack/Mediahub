<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Show the registration form
    public function create()
    {
        return view('auth.inscription');
    }

    // 2. Handle the registration submission
    public function store(StoreUserRequest $request)
    {
        // Create the user (password is automatically hashed by the model)
        $user = User::create($request->validated());

        // Log the user in immediately
        Auth::login($user);

        return redirect()->route('accueil')
            ->with('succes', 'Bienvenue sur MediaHub !');
    }

    // 3. Show the login form
    public function creerConnexion()
    {
        return view('auth.connexion');
    }

    // 4. Handle the login submission
    public function connecter(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ])->onlyInput('email');
        }

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        return redirect()->intended(route('accueil'));
    }

    // 5. Handle logout
    public function deconnecter(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('accueil');
    }
}
