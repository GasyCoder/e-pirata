<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'title' => 'Première Énigme',
                'description' => 'Résoudre votre première énigme',
                'icon' => 'fa-compass',
                'condition_type' => 'enigmas_completed',
                'condition_value' => 1,
                'points' => 50
            ],
            [
                'title' => 'Maître des Énigmes',
                'description' => 'Résoudre 10 énigmes',
                'icon' => 'fa-puzzle-piece',
                'condition_type' => 'enigmas_completed',
                'condition_value' => 10,
                'points' => 200
            ],
            [
                'title' => 'Explorateur',
                'description' => 'Terminer votre premier chapitre',
                'icon' => 'fa-map',
                'condition_type' => 'chapters_completed',
                'condition_value' => 1,
                'points' => 100
            ],
            [
                'title' => 'Série Gagnante',
                'description' => 'Résoudre 3 énigmes en une journée',
                'icon' => 'fa-fire',
                'condition_type' => 'daily_streak',
                'condition_value' => 3,
                'points' => 150
            ],
            [
                'title' => 'Pirate Légendaire',
                'description' => 'Accumuler 1000 points',
                'icon' => 'fa-crown',
                'condition_type' => 'total_points',
                'condition_value' => 1000,
                'points' => 500
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title']],
                $achievement
            );
        }
    }
}
