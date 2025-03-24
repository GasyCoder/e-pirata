<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $chapters = [
            [
                'title' => 'Le Début de l\'Aventure',
                'description' => 'Votre voyage commence ici. Découvrez les premiers mystères qui vous attendent.',
                'story_content' => 'Vous vous réveillez sur une plage mystérieuse, une carte énigmatique à la main...',
                'order' => 1,
                'location' => 'Plage de l\'Éveil',
                'weather_condition' => 'Ensoleillé',
                'required_items' => json_encode(['carte', 'boussole']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Les Secrets de la Carte',
                'description' => 'Déchiffrez les mystères cachés dans les anciennes cartes des pirates.',
                'story_content' => 'Les cartes révèlent des indices cryptiques menant à un trésor légendaire...',
                'order' => 2,
                'location' => 'Taverne du Cartographe',
                'weather_condition' => 'Nuageux',
                'required_items' => json_encode(['longue-vue', 'compas']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'L\'Île aux Énigmes',
                'description' => 'Explorez une île remplie de pièges et d\'énigmes complexes.',
                'story_content' => 'L\'île cache des secrets millénaires protégés par d\'anciens mécanismes...',
                'order' => 3,
                'location' => 'Île Mystérieuse',
                'weather_condition' => 'Orageux',
                'required_items' => json_encode(['torche', 'corde']),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($chapters as $chapter) {
            DB::table('chapters')->insert($chapter);
        }

        // Associer les énigmes existantes aux chapitres
        $enigmasByChapter = [
            1 => ['Le Secret du Coffre', 'La Carte Mystérieuse', 'La Boussole Enchantée'],
            2 => ['Le Navire Fantôme', 'Le Crâne Parlant', 'Le Perroquet Bavard'],
            3 => ['La Longue-Vue du Capitaine', 'L\'Ancre Perdue', 'Le Rhum du Sage']
        ];

        foreach ($enigmasByChapter as $chapterId => $enigmaTitles) {
            DB::table('enigmas')
                ->whereIn('title', $enigmaTitles)
                ->update(['chapter_id' => $chapterId]);
        }
    }

    public function down()
    {
        DB::table('chapters')->truncate();
        DB::table('enigmas')->update(['chapter_id' => null]);
    }
};
