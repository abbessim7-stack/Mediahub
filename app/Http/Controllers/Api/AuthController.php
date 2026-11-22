<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function connecter(Request $request)
    {
        // 1. Validate the incoming request
        $identifiants = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Attempt to log the user in
        if (! Auth::attempt($identifiants)) {
            return response()->json([
                'message' => 'Identifiants incorrects.'
            ], 401);
        }

        // 3. Generate the API token
        $utilisateur = Auth::user();
        $jeton = $utilisateur->createToken('api')->plainTextToken;

        // 4. Return the token as JSON
        return response()->json([
            'token' => $jeton
        ]);
    }
}
