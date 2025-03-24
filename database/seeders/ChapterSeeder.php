<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\MiniGame;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        // Chapitre 1 : L'Appel de la Mer
        $chapter1 = Chapter::create([
            'title' => 'L\'Appel de la Mer',
            'description' => 'Votre aventure commence sur les quais de Port-Royal, où une mystérieuse carte vous attend.',
            'story_content' => "Le soleil se lève sur Port-Royal, baignant les quais d'une lueur dorée. L'air salé vous chatouille les narines tandis que vous observez les navires se balancer doucement dans le port. C'est ici que tout commence, avec une mystérieuse carte laissée par le légendaire Capitaine Barbe-Rouge.\n\nLa légende raconte qu'avant sa disparition, il a dispersé son trésor aux quatre coins des Caraïbes, ne laissant que des énigmes pour guide. Aujourd'hui, vous êtes sur le point de commencer cette quête extraordinaire.",
            'order' => 1,
            'location' => 'Port-Royal',
            'weather_condition' => 'Ensoleillé',
            'required_items' => json_encode(['Carte marine', 'Boussole'])
        ]);

        // Mini-jeux du Chapitre 1
        MiniGame::create([
            'chapter_id' => $chapter1->id,
            'type' => 'memory',
            'title' => 'Mémoire du Marin',
            'description' => 'Testez votre mémoire en associant les paires d\'objets pirates. Un vrai marin doit avoir l\'œil vif !',
            'game_data' => json_encode([
                'time_limit' => 120,
                'pairs_count' => 8,
                'cards' => [
                    ['id' => 1, 'name' => 'Compas', 'image' => '/images/cards/compass.png'],
                    ['id' => 2, 'name' => 'Carte', 'image' => '/images/cards/map.png'],
                    ['id' => 3, 'name' => 'Sabre', 'image' => '/images/cards/sword.png'],
                    ['id' => 4, 'name' => 'Perroquet', 'image' => '/images/cards/parrot.png'],
                    ['id' => 5, 'name' => 'Gouvernail', 'image' => '/images/cards/wheel.png'],
                    ['id' => 6, 'name' => 'Coffre', 'image' => '/images/cards/chest.png'],
                    ['id' => 7, 'name' => 'Ancre', 'image' => '/images/cards/anchor.png'],
                    ['id' => 8, 'name' => 'Longue-vue', 'image' => '/images/cards/spyglass.png']
                ]
            ]),
            'points_reward' => 100
        ]);

        // Chapitre 2 : Les Secrets de l'Île Tortue
        $chapter2 = Chapter::create([
            'title' => 'Les Secrets de l\'Île Tortue',
            'description' => 'Votre quête vous mène à l\'Île Tortue, repaire légendaire des pirates.',
            'story_content' => "L'Île Tortue se dresse devant vous, ses falaises escarpées cachant des siècles d'histoire pirate. Les tavernes du port regorgent d'histoires sur le trésor de Barbe-Rouge, mais peu savent que l'île elle-même est une énigme.\n\nDans les ruelles tortueuses du village pirate, chaque pierre pourrait cacher un indice, chaque habitant pourrait détenir un fragment du secret. La nuit tombante n'est pas votre ennemie, elle pourrait même révéler des indices invisibles à la lumière du jour.",
            'order' => 2,
            'location' => 'Île Tortue',
            'weather_condition' => 'Nuit étoilée',
            'required_items' => json_encode(['Lanterne', 'Clé ancienne'])
        ]);

        // Mini-jeux du Chapitre 2
        MiniGame::create([
            'chapter_id' => $chapter2->id,
            'type' => 'decode',
            'title' => 'Le Code des Pirates',
            'description' => 'Décryptez le code secret utilisé par les pirates pour protéger leurs trésors.',
            'game_data' => json_encode([
                'cipher_text' => 'XQZM BVHF KLYN PSTR',
                'hints' => [
                    'Les pirates utilisaient souvent un décalage de trois lettres',
                    'Le message contient un lieu important'
                ],
                'solution' => 'CAVE NORD SOUS FORT'
            ]),
            'points_reward' => 150
        ]);

        // Chapitre 3 : La Tempête des Bermudes
        Chapter::create([
            'title' => 'La Tempête des Bermudes',
            'description' => 'Affrontez les dangers du Triangle des Bermudes pour suivre la piste du trésor.',
            'story_content' => "Les eaux du Triangle des Bermudes sont aussi mystérieuses que dangereuses. Les nuages s'amoncellent à l'horizon, présageant une tempête comme seuls les marins les plus aguerris en ont vu.\n\nLa boussole s'affole, les vents changent constamment de direction, et des lueurs étranges dansent sur les flots. C'est ici, au cœur de ces eaux maudites, que Barbe-Rouge aurait caché l'une des clés de son trésor.",
            'order' => 3,
            'location' => 'Triangle des Bermudes',
            'weather_condition' => 'Tempête',
            'required_items' => json_encode(['Boussole magique', 'Pierre de lune'])
        ]);
    }
}
