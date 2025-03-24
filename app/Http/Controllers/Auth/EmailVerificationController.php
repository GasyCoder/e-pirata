<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    public function __construct()
    {
        // Appliquer le middleware 'signed' uniquement sur la méthode verify
        // et appliquer le middleware 'auth' sur la méthode send pour les utilisateurs connectés
        $this->middleware('signed')->only('verify');
        $this->middleware('auth')->only('send');
    }

    // Méthode de vérification accessible sans authentification préalable
    public function verify(Request $request)
    {
        // Vérifier la validité du lien signé
        if (!$request->hasValidSignature()) {
            Log::error('Lien invalide ou expiré', ['url' => $request->fullUrl()]);
            return redirect()->route('login')->with('error', 'Lien invalide ou expiré.');
        }

        // Récupérer l'utilisateur à partir de l'ID fourni dans l'URL
        $user = User::find($request->id);
        if (!$user) {
            Log::error('Utilisateur introuvable', ['user_id' => $request->id]);
            return redirect()->route('login')->with('error', 'Utilisateur introuvable.');
        }

        // Si l'utilisateur a déjà vérifié son email, le connecter (s'il ne l'est pas déjà) et rediriger vers le dashboard
        if ($user->hasVerifiedEmail()) {
            if (!Auth::check()) {
                Auth::login($user);
                session()->regenerate();
            }
            return redirect()->route('dashboard');
        }

        // Marquer l'email comme vérifié
        $user->markEmailAsVerified();

        // Connecter automatiquement l'utilisateur après vérification
        Auth::login($user);

        // Régénérer la session pour éviter des problèmes de session
        session()->regenerate();

        // Rediriger vers le dashboard avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Email vérifié et connecté avec succès !');
    }

    // Méthode pour renvoyer l'email de vérification (accessible uniquement pour les utilisateurs connectés)
    public function send(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        // Générer un lien temporaire signé valable 60 minutes
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', // Cette route doit être définie dans votre fichier routes/web.php
            Carbon::now()->addMinutes(60),
            ['id' => $user->id]
        );

        // Envoyer l'email avec le lien de vérification
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));

        return back()->with('resent', true);
    }
}
