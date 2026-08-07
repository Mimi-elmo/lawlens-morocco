<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Inscription d'un entrepreneur
     *
     * Crée un compte entrepreneur et retourne un jeton Sanctum.
     *
     * @unauthenticated
     *
     * @response status=201 scenario="success" {
     *  "user": {
     *      "id": 1,
     *      "name": "Yasmine Alaoui",
     *      "email": "yasmine@example.com",
     *      "role": "entrepreneur",
     *      "statut": "actif"
     *  },
     *  "token": "1|abc123..."
     * }
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'entrepreneur',
            'statut' => 'actif',
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Connexion
     *
     * Retourne le profil utilisateur et un jeton Sanctum.
     *
     * @unauthenticated
     *
     * @response scenario="success" {
     *  "user": {
     *      "id": 1,
     *      "name": "Yasmine Alaoui",
     *      "email": "yasmine@example.com",
     *      "role": "entrepreneur"
     *  },
     *  "token": "1|abc123..."
     * }
     * @response status=401 scenario="invalid credentials" {
     *  "message": "Identifiants invalides."
     * }
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Identifiants invalides.',
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Déconnexion
     *
     * Révoque le jeton Sanctum courant.
     *
     * @response {
     *  "message": "Déconnecté avec succès."
     * }
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnecté avec succès.',
        ]);
    }

    /**
     * Profil de l'utilisateur connecté
     *
     * @response {
     *  "user": {
     *      "id": 1,
     *      "name": "Yasmine Alaoui",
     *      "email": "yasmine@example.com",
     *      "role": "entrepreneur"
     *  }
     * }
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
