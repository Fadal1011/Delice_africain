<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessTokenFactory;

class AuthController extends Controller
{
    use ResponseTrait;
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
            /**@var User $user */
            $token = $user->createToken('auth-token')->plainTextToken;

            // Retourner une réponse JSON avec le token et les informations de l'utilisateur
            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        } else {
            // Si les informations d'identification sont incorrectes, retourner un message d'erreur
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    // public function logout()
    // {
    //     try {
    //         /**@var User $user */
    //         $user = Auth::user();
    //         $user->token()->revoke();
    //         return $this->responseData("Deconnexion réussie", true, Response::HTTP_ACCEPTED);
    //     } catch (\Throwable $th) {
    //         return $this->responseData($th->getMessage(), false, Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function logout()
    {
        $user = Auth::user();
        /**@var User $user */
        $user->currentAccessToken()->delete();
        return Response(['data' => 'User Logout successfully.'],200);
    }
}
