<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Achievement;

return new class extends Migration
{
    public function up()
    {
        $achievements = [
            [
                'title' => 'Premier Pas',
                'description' => 'Résoudre votre première énigme',
                'icon' => 'fa-star',
                'points' => 50,
                'type' => 'enigma_completion',
                'condition_type' => 'completion',
                'condition_value' => 1,
                'requirements' => json_encode(['completed_enigmas' => 1])
            ],
            [
                'title' => 'Apprenti Pirate',
                'description' => 'Résoudre 5 énigmes',
                'icon' => 'fa-compass',
                'points' => 100,
                'type' => 'enigma_completion',
                'condition_type' => 'completion',
                'condition_value' => 5,
                'requirements' => json_encode(['completed_enigmas' => 5])
            ],
            [
                'title' => 'Maître des Énigmes',
                'description' => 'Résoudre une énigme sans utiliser d\'indices',
                'icon' => 'fa-lightbulb',
                'points' => 75,
                'type' => 'no_hints',
                'condition_type' => 'no_hints',
                'condition_value' => 0,
                'requirements' => json_encode(['hints_used' => 0])
            ],
            [
                'title' => 'Éclair de Génie',
                'description' => 'Résoudre une énigme en moins de 5 minutes',
                'icon' => 'fa-bolt',
                'points' => 100,
                'type' => 'quick_solve',
                'condition_type' => 'time',
                'condition_value' => 300,
                'requirements' => json_encode(['time_limit' => 300])
            ],
            [
                'title' => 'Explorateur',
                'description' => 'Compléter votre premier chapitre',
                'icon' => 'fa-map',
                'points' => 200,
                'type' => 'chapter_completion',
                'condition_type' => 'chapter',
                'condition_value' => 1,
                'requirements' => json_encode(['completed_chapters' => 1])
            ]
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }

    public function down()
    {
        Achievement::truncate();
    }
};
