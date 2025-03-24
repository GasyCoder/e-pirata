<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $achievements = Achievement::with(['users' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        return view('achievements.index', compact('achievements'));
    }

    public function checkAchievements(User $user)
    {
        $newAchievements = [];

        // Vérifier les achievements basés sur le nombre d'énigmes résolues
        $completedEnigmas = $user->enigmas()->wherePivot('completed', true)->count();
        
        if ($completedEnigmas >= 1) {
            $newAchievements[] = $this->unlockAchievement($user, 'first_enigma');
        }
        if ($completedEnigmas >= 5) {
            $newAchievements[] = $this->unlockAchievement($user, 'five_enigmas');
        }
        if ($completedEnigmas >= 10) {
            $newAchievements[] = $this->unlockAchievement($user, 'ten_enigmas');
        }

        // Vérifier les achievements basés sur les points
        $totalPoints = $user->getTotalPoints();
        
        if ($totalPoints >= 100) {
            $newAchievements[] = $this->unlockAchievement($user, 'points_100');
        }
        if ($totalPoints >= 500) {
            $newAchievements[] = $this->unlockAchievement($user, 'points_500');
        }
        if ($totalPoints >= 1000) {
            $newAchievements[] = $this->unlockAchievement($user, 'points_1000');
        }

        // Vérifier les achievements basés sur les chapitres complétés
        $completedChapters = $user->chapters()->wherePivot('completed', true)->count();
        
        if ($completedChapters >= 1) {
            $newAchievements[] = $this->unlockAchievement($user, 'first_chapter');
        }
        if ($completedChapters >= 3) {
            $newAchievements[] = $this->unlockAchievement($user, 'three_chapters');
        }

        // Retirer les null values (achievements déjà débloqués)
        $newAchievements = array_filter($newAchievements);

        return $newAchievements;
    }

    private function unlockAchievement(User $user, string $achievementCode)
    {
        $achievement = Achievement::where('code', $achievementCode)->first();
        
        if (!$achievement) {
            return null;
        }

        $alreadyUnlocked = $user->achievements()->where('achievement_id', $achievement->id)->exists();
        
        if ($alreadyUnlocked) {
            return null;
        }

        $user->achievements()->attach($achievement->id, [
            'unlocked_at' => now()
        ]);

        return $achievement;
    }
}
