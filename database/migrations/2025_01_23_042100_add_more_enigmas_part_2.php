<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $enigmas = [
            [
                'title' => 'La Barre Mystérieuse',
                'description' => 'La barre du navire semble avoir une volonté propre. Elle tourne toute seule et indique une direction.',
                'content' => 'La barre a tourné de 90° vers la droite 3 fois, puis de 180° vers la gauche. Dans quelle direction pointe-t-elle maintenant ? (N, S, E, O)',
                'answer' => 'E',
                'points' => 25,
                'difficulty' => 2,
                'hint' => 'Dessinez les rotations : 90° × 3 = 270° vers la droite, puis 180° vers la gauche. Commencez face au Nord.'
            ],
            [
                'title' => 'La Clé des Songes',
                'description' => 'Une clé dorée brille dans vos rêves. Ses dents forment un message codé.',
                'content' => 'Les dents de la clé ont différentes hauteurs : 2, 3, 2. Si 1=A, 2=B, 3=C, que dit la clé ?',
                'answer' => 'BCB',
                'points' => 20,
                'difficulty' => 1,
                'hint' => 'Chaque hauteur correspond à une lettre : 2=B, 3=C, 2=B'
            ],
            [
                'title' => 'Le Sablier Enchanté',
                'description' => 'Ce sablier magique ne mesure pas le temps normal. Chaque grain raconte une histoire.',
                'content' => 'Dans le sablier, il y a 4 grains rouges, 3 grains bleus et 2 grains dorés. Chaque grain rouge vaut 5, chaque grain bleu vaut 3, et chaque grain doré vaut 7. Quelle est la valeur totale ?',
                'answer' => '41',
                'points' => 30,
                'difficulty' => 2,
                'hint' => 'Calculez pour chaque couleur : Rouge = 4×5, Bleu = 3×3, Doré = 2×7'
            ]
        ];

        foreach ($enigmas as $enigma) {
            DB::table('enigmas')->insert($enigma);
        }
    }

    public function down()
    {
        DB::table('enigmas')->whereIn('title', [
            'La Barre Mystérieuse',
            'La Clé des Songes',
            'Le Sablier Enchanté'
        ])->delete();
    }
};
