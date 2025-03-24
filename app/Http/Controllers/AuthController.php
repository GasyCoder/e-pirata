<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')->with('error', 'Vous devez vérifier votre e-mail avant de vous connecter.');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase() // Majuscules + minuscules
                    ->numbers() // Au moins un chiffre
                    ->symbols(), // Au moins un caractère spécial
                'regex:/^[A-Z]/', // La première lettre doit être une majuscule
                'confirmed' // Vérifie que le champ password_confirmation est identique
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Envoi de l'email de vérification
        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('verification.notice')
                         ->with('message', 'Un e-mail de confirmation vous a été envoyé. Vérifiez votre boîte mail.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
