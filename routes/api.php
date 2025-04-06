<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\EnigmaApiController;
use App\Http\Controllers\Api\TreasureApiController;
use App\Http\Controllers\EnigmaController;


Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne bien 🎉']);
});
// Ces routes sont pour mon test personnel via thunder client pour avoir tokende l'utilisateur
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

    Route::get('/enigmas', [EnigmaApiController::class, 'index'])->name('enigmas.index');
    Route::post('/enigmas/{enigmaId}/validate', [EnigmaApiController::class, 'validateAnswer']);
    Route::get('/enigmas/{enigmaId}/hint/{hintNumber}', [EnigmaApiController::class, 'getHint']);
    Route::post('/fragments/generate', [EnigmaApiController::class, 'generateUniqueFragment']);

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

    // Routes pour les notes - noter l'ordre des routes
        Route::post('/notes/clear-all', [NoteController::class, 'clearAll'])->middleware('admin');
        Route::delete('/notes/{enigma_id}', [NoteController::class, 'destroy'])->middleware('admin');
        Route::get('/notes/{enigma_id}', [NoteController::class, 'show'])
            ->where('enigma_id', '[0-9]+');
            Route::post('/notes/{enigma_id}', [NoteController::class, 'storeOrUpdate'])
                ->where('enigma_id', '[0-9]+');
        Route::get('/notes', [NoteController::class, 'getUserNotes']);

        Route::post('/notes/batch', [NoteController::class, 'storeOrUpdateBatch']);
        Route::get('/user/notes', [NoteController::class, 'getAllNotesForUser']);
    // Route accéder aux pages (CGU, CGV)
    Route::get('/pages/{slug}', [PageController::class, 'show']);

});

// Routes protégées pour admin uniquement
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('/pages', [PageController::class, 'index']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
});

