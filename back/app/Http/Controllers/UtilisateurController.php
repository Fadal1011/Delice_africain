<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    use ResponseTrait;
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            'password_confirmation' => 'required|string|min:8',
            'numero_telephone' => 'required|string|unique:users'
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "numero_telephone" => $request->numero_telephone,
            "photo" => $request->photo,
            "role" => "client"
        ]);

        return $this->responseData('User created successfully.', true, Response::HTTP_OK,  $user);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            /**@var User $user */
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
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

}
