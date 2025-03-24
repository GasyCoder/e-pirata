<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnigmaController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TreasureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationController;

// ✅ Page d'accueil
Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
Route::get('/contacte', function () {
    return view('contacte'); // Créez une vue 'contacte.blade.php'
});
Route::get('/FAQ', function () {
    return view('/FAQ'); // Créez une vue 'contacte.blade.php'
});

Route::get('/nous', function () {
    return view('/nous'); // Créez une vue 'contacte.blade.php'
});

Route::get('/regles', function () {
    return view('/regles'); // Créez une vue 'contacte.blade.php'
});

Route::get('/Remboursement', function () {
    return view('/Remboursement'); // Créez une vue 'contacte.blade.php'
});

Route::get('/CGU', function () {
    return view('/CGU'); // Créez une vue 'contacte.blade.php'
});

Route::get('/CGV', function () {
    return view('/CGV'); // Créez une vue 'contacte.blade.php'
});

Route::get('/participer', function () {
    return view('/participer'); // Créez une vue 'contacte.blade.php'
});
Route::get('/enigme', function () {
    return view('/enigme'); // Créez une vue 'contacte.blade.php'
});
Route::get('/inscriptions', function () {
    return view('/inscriptions'); // Créez une vue 'contacte.blade.php'
});
Route::get('/connexion', function () {
    return view('/connexion'); // Créez une vue 'contacte.blade.php'
});

// Fahhhhhhhh
Route::get('/appele', function () {
    return view('/appele'); // Créez une vue 'contacte.blade.php'
});



// ✅ Routes d'authentification pour invités
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // ✅ Connexion via Google OAuth
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// ✅ Routes de vérification d'email (doit être connecté)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/resend', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ✅ Routes protégées (connexion + email vérifié obligatoire)
Route::middleware(['auth', 'verified'])->group(function () {
    // 🎯 **Tableau de bord**
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🎯 **Profil utilisateur**
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🎯 **Chapitres**
    Route::get('/chapters', [ChapterController::class, 'index'])->name('chapters.index');
    Route::get('/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
    Route::post('/chapters/{chapter}/complete', [ChapterController::class, 'completeChapter'])->name('chapters.complete');
    Route::get('/chapters/{chapter}/mini-games/{miniGame}', [ChapterController::class, 'playMiniGame'])->name('chapters.play-mini-game');
    Route::post('/mini-games/{miniGame}/complete', [ChapterController::class, 'completeMiniGame'])->name('mini-games.complete');

    // 🎯 **Énigmes**
    Route::get('/enigmas', [EnigmaController::class, 'index'])->name('enigmas.index');
    Route::get('/enigmas/{enigma}', [EnigmaController::class, 'show'])->name('enigmas.show');
    Route::post('/enigmas/{enigma}/verify', [EnigmaController::class, 'verify'])->name('enigmas.verify');
    Route::get('/enigmas/{enigma}/hint', [EnigmaController::class, 'hint'])->name('enigmas.hint');

    // 🎯 **Trésor**
    Route::get('/treasure/validate', [TreasureController::class, 'showValidationForm'])->name('treasure.validate');
    Route::post('/treasure/validate', [TreasureController::class, 'checkTreasureCode'])->name('treasure.check');

    // 🎯 **Achievements (Récompenses)**
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
});

// ✅ Route de test temporaire pour les images
Route::get('/test-images', function () {
    return view('test-images');
});

// ✅ Pages légales
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy-policy');
Route::view('/terms', 'legal.terms')->name('terms');

// ✅ Charger les routes d'authentification par défaut de Laravel (si utilisées)
require __DIR__ . '/auth.php';
