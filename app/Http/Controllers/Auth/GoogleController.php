<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Rediriger l'utilisateur vers la page d'authentification Google.
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')
                           ->with('error', 'Erreur lors de la redirection vers Google : ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les informations de l'utilisateur depuis Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            \Log::info('Google user data:', [
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email
            ]);

            // Chercher l'utilisateur par son Google ID ou email
            $user = User::where('google_id', $googleUser->id)
                       ->orWhere('email', $googleUser->email)
                       ->first();

            // Si l'utilisateur n'existe pas, le créer
            if (!$user) {
                \Log::info('Creating new user from Google data');
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)), // Générer un mot de passe aléatoire
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'email_verified_at' => now(), // L'email est déjà vérifié par Google
                    'points' => 0, // Points initiaux
                ]);
                \Log::info('New user created successfully', ['user_id' => $user->id]);
            } else {
                \Log::info('Updating existing user with Google data', ['user_id' => $user->id]);
                // Mettre à jour les informations Google si l'utilisateur existe
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }

            // Connecter l'utilisateur
            Auth::login($user);

            return redirect()->route('dashboard')
                           ->with('success', 'Connexion réussie avec Google !');

        } catch (Exception $e) {
            \Log::error('Erreur Google OAuth: ' . $e->getMessage());
            return redirect()->route('login')
                           ->with('error', 'Une erreur est survenue lors de la connexion avec Google : ' . $e->getMessage());
        }
    }
}
