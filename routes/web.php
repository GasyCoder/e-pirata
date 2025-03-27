<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EnigmaController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TreasureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\EmailVerificationController;

// ✅ Page d'accueil
Route::get('/', function () {
    return view('welcome');
});


// Route::redirect('/', '/login');

// ✅ Pages informatives
Route::get('/contacte', function () { return view('contacte'); });
Route::get('/FAQ', function () { return view('FAQ'); });
Route::get('/nous', function () { return view('nous'); });
Route::get('/regles', function () { return view('regles'); });
Route::get('/Remboursement', function () { return view('Remboursement'); });
Route::get('/cgu', [PageController::class, 'show'])->name('pages.cgu')->defaults('slug', 'cgu');
Route::get('/cgv', [PageController::class, 'show'])->name('pages.cgv')->defaults('slug', 'cgv');
Route::get('/participer', function () { return view('participer'); });
Route::get('/enigme', function () { return view('enigme'); });
Route::get('/inscriptions', function () { return view('inscriptions'); });
Route::get('/connexion', function () { return view('connexion'); });
Route::get('/appele', function () { return view('appele'); });


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
});

// ✅ Connexion via Google OAuth (pas besoin d'être dans un groupe middleware)
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Routes d'administration (protégées)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
});

// ✅ Routes protégées (connexion + email vérifié obligatoire)
Route::middleware(['auth', 'verified'])->group(function () {
    // 🎯 **Tableau de bord**
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🎯 **Profil utilisateur**
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
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

// ✅ Charger les routes d'authentification par défaut de Laravel
// Cette ligne ne doit pas être commentée, car vous utilisez les contrôleurs standard de Laravel
require __DIR__ . '/auth.php';
