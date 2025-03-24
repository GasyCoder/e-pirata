<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EnigmaApiController;
use App\Http\Controllers\Api\TreasureApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route pour récupérer les informations de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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
