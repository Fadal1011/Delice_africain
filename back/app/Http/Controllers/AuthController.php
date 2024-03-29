<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessTokenFactory;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Vérifier si les informations d'identification sont correctes
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Si les informations d'identification sont correctes, récupérer l'utilisateur authentifié
            $user = Auth::user();
    
            // Créer un token d'authentification pour l'utilisateur
            $token = $user->createToken('auth-token')->plainTextToken;
    
            // Retourner une réponse JSON avec le token et les informations de l'utilisateur
            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        } else {
            // Si les informations d'identification sont incorrectes, retourner un message d'erreur
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
} 