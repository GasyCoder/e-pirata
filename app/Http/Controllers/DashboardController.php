<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enigma;
use App\Models\Chapter;
use App\Models\UserProgress;
use App\Models\UserProgressChapter;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques de progression
        $totalEnigmas = Enigma::count();
        $completedEnigmas = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();
        $enigmaProgress = $totalEnigmas > 0 ? ($completedEnigmas / $totalEnigmas) * 100 : 0;

        $totalChapters = Chapter::count();
        $completedChapters = UserProgressChapter::where('user_id', $user->id)
            ->where('completed', true)
            ->count() ?? 0;
        $chapterProgress = $totalChapters > 0 ? ($completedChapters / $totalChapters) * 100 : 0;

        // Statistiques supplémentaires
        $totalEnigmasCompleted = $completedEnigmas;
        $totalHintsUsed = UserProgress::where('user_id', $user->id)
            ->sum('hints_used') ?? 0;
        $totalTimeSpent = UserProgress::where('user_id', $user->id)
            ->sum('time_spent') ?? 0;

        // Convertir le temps total en une chaîne lisible
        $hours = floor($totalTimeSpent / 3600);
        $minutes = floor(($totalTimeSpent % 3600) / 60);
        $playTime = $hours . 'h ' . $minutes . 'm';

        // Récupérer le chapitre en cours
        $currentChapter = Chapter::whereDoesntHave('userProgress', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('completed', true);
        })->orderBy('order')->first();

        // Si tous les chapitres sont complétés, prendre le dernier
        if (!$currentChapter) {
            $currentChapter = Chapter::orderBy('order', 'desc')->first();
        }

        // Récupérer la prochaine énigme non complétée du chapitre en cours
        $nextEnigma = null;
        if ($currentChapter) {
            $nextEnigma = Enigma::where('chapter_id', $currentChapter->id)
                ->whereDoesntHave('userProgress', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->where('completed', true);
                })
                ->orderBy('order')
                ->first();
        }

        // Classement et points
        $userRank = User::where('points', '>', $user->points ?? 0)->count() + 1;
        $totalPoints = $user->points ?? 0;

        // Récupérer le top 10 des utilisateurs
        $topUsers = User::orderBy('points', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'points' => $user->points,
                    'avatar' => $user->avatar ?? 'default.png'
                ];
            });

        // Récupérer les récompenses récentes
        $recentAchievements = Achievement::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Meilleure série et temps de jeu
        $bestStreak = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at')
            ->get()
            ->reduce(function ($carry, $item) {
                if (!isset($carry['lastDate'])) {
                    return ['streak' => 1, 'maxStreak' => 1, 'lastDate' => $item->completed_at];
                }

                $daysDiff = Carbon::parse($carry['lastDate'])->diffInDays($item->completed_at);
                
                if ($daysDiff <= 1) {
                    $carry['streak']++;
                    $carry['maxStreak'] = max($carry['maxStreak'], $carry['streak']);
                } else {
                    $carry['streak'] = 1;
                }
                
                $carry['lastDate'] = $item->completed_at;
                return $carry;
            }, ['streak' => 0, 'maxStreak' => 0])['maxStreak'] ?? 0;

        // Chapitres avec leur progression
        $chapters = Chapter::with(['enigmas', 'userProgress' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->orderBy('order')
        ->get();

        // Succès débloqués
        $achievements = Achievement::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Dernières énigmes résolues
        $recentlyCompleted = UserProgress::with('enigma')
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();

        // Statistiques de performance
        $performanceStats = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->get()
            ->reduce(function ($carry, $item) {
                $carry['totalAttempts'] += $item->attempts;
                $carry['firstTryCount'] += ($item->attempts === 1) ? 1 : 0;
                $carry['avgTimeSpent'] += $item->time_spent;
                $carry['count']++;
                return $carry;
            }, ['totalAttempts' => 0, 'firstTryCount' => 0, 'avgTimeSpent' => 0, 'count' => 0]);

        $avgAttempts = $performanceStats['count'] > 0 ? 
            round($performanceStats['totalAttempts'] / $performanceStats['count'], 1) : 0;
        $firstTryPercentage = $performanceStats['count'] > 0 ? 
            round(($performanceStats['firstTryCount'] / $performanceStats['count']) * 100) : 0;
        $avgTimePerEnigma = $performanceStats['count'] > 0 ? 
            round($performanceStats['avgTimeSpent'] / $performanceStats['count']) : 0;

        return view('dashboard', compact(
            'user',
            'totalEnigmas',
            'completedEnigmas',
            'enigmaProgress',
            'totalChapters',
            'completedChapters',
            'chapterProgress',
            'totalEnigmasCompleted',
            'totalHintsUsed',
            'totalTimeSpent',
            'playTime',
            'userRank',
            'totalPoints',
            'bestStreak',
            'chapters',
            'achievements',
            'recentlyCompleted',
            'recentAchievements',
            'avgAttempts',
            'firstTryPercentage',
            'avgTimePerEnigma',
            'currentChapter',
            'nextEnigma',
            'topUsers'
        ));
    }
}
