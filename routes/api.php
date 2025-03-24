<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EnigmaApiController;
use App\Http\Controllers\Api\TreasureApiController;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
});


// Route pour récupérer les informations de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    if ($request->user()) {
        return response()->json($request->user());
    }
    return response()->json(['error' => 'Utilisateur non authentifié'], 401);
});

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    // Routes énigmes
    Route::post('/enigmas/{enigmaId}/validate', [EnigmaApiController::class, 'validateAnswer']);
    Route::get('/enigmas/{enigmaId}/hint/{hintNumber}', [EnigmaApiController::class, 'getHint']);

    // User fragments
    Route::get('/user/fragments', [EnigmaApiController::class, 'getUserFragments']);

    // Trésor
    Route::post('/treasure/validate', [TreasureApiController::class, 'validateTreasureCode']);

    // Progression utilisateur
    Route::get('/user/progress', [EnigmaApiController::class, 'getUserProgress']);

    // Classement
    Route::get('/leaderboard', [TreasureApiController::class, 'getLeaderboard']);

    // Récents gagnants
    Route::get('/winners/recent', [TreasureApiController::class, 'getRecentWinners']);

    // Vérifier si l'utilisateur a complété toutes les énigmes
    Route::get('/user/completed-all', [EnigmaApiController::class, 'hasCompletedAllEnigmas']);
});
