<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\MiniGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $chapters = Chapter::orderBy('order')->get();
        
        return view('chapters.index', compact('chapters', 'user'));
    }

    public function show(Chapter $chapter)
    {
        $user = Auth::user();
        
        // Vérifier si le chapitre est accessible
        $previousChapter = Chapter::where('order', '<', $chapter->order)
                                ->orderBy('order', 'desc')
                                ->first();

        if ($previousChapter && !$previousChapter->isCompletedByUser($user->id)) {
            return redirect()->route('chapters.index')
                           ->with('error', 'Vous devez d\'abord compléter le chapitre précédent.');
        }

        // Charger les mini-jeux disponibles
        $miniGames = $chapter->miniGames()
                            ->get()
                            ->filter(function($game) use ($user) {
                                return $game->isUnlocked($user);
                            });

        // Charger les énigmes du chapitre
        $enigmas = $chapter->enigmas()
                          ->orderBy('order')
                          ->get();

        // Récupérer la progression de l'utilisateur
        $progress = $user->chapters()
                        ->where('chapter_id', $chapter->id)
                        ->first();

        return view('chapters.show', compact('chapter', 'miniGames', 'enigmas', 'progress'));
    }

    public function playMiniGame(Chapter $chapter, MiniGame $miniGame)
    {
        $user = Auth::user();

        if (!$miniGame->isUnlocked($user)) {
            return redirect()->route('chapters.show', $chapter)
                           ->with('error', 'Ce mini-jeu n\'est pas encore débloqué.');
        }

        $gameData = $miniGame->getGameData();

        return view('mini-games.' . $miniGame->type, compact('miniGame', 'gameData'));
    }

    public function completeChapter(Chapter $chapter)
    {
        $user = Auth::user();
        
        // Vérifier si toutes les énigmes sont résolues
        $allEnigmasCompleted = $chapter->enigmas()
                                     ->get()
                                     ->every(function($enigma) use ($user) {
                                         return $enigma->isCompletedByUser($user->id);
                                     });

        if (!$allEnigmasCompleted) {
            return redirect()->route('chapters.show', $chapter)
                           ->with('error', 'Vous devez résoudre toutes les énigmes pour compléter ce chapitre.');
        }

        // Mettre à jour la progression
        $user->chapters()->updateExistingPivot($chapter->id, [
            'completed' => true,
            'completed_at' => now(),
        ]);

        // Débloquer le prochain chapitre
        $nextChapter = Chapter::where('order', '>', $chapter->order)
                             ->orderBy('order')
                             ->first();

        if ($nextChapter) {
            $user->chapters()->attach($nextChapter->id, [
                'completed' => false,
                'points_earned' => 0,
            ]);
        }

        return redirect()->route('chapters.index')
                        ->with('success', 'Chapitre complété ! Un nouveau chapitre a été débloqué.');
    }
}
