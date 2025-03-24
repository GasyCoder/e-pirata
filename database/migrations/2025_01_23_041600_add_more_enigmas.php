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
                'title' => 'Le Perroquet Bavard',
                'description' => 'Un perroquet mystérieux détient le secret d\'une carte au trésor. Déchiffrez son message codé pour avancer.',
                'content' => 'Je répète toujours deux fois la même chose, mais à l\'envers. Si tu entends "ORTOR", quel est mon véritable message ?',
                'answer' => 'TORO',
                'points' => 20,
                'difficulty' => 2,
                'hint' => 'Écoutez attentivement le perroquet, il dit tout deux fois mais inversé.'
            ],
            [
                'title' => 'La Longue-Vue du Capitaine',
                'description' => 'À travers la longue-vue enchantée, les chiffres se transforment en lettres. Que voyez-vous ?',
                'content' => 'En regardant à travers la longue-vue, les chiffres 13-1-18-5-5 apparaissent. Que signifient-ils ?',
                'answer' => 'MAREE',
                'points' => 30,
                'difficulty' => 3,
                'hint' => 'Chaque chiffre correspond à la position d\'une lettre dans l\'alphabet.'
            ],
            [
                'title' => 'L\'Ancre Perdue',
                'description' => 'Une ancre légendaire est cachée quelque part dans ces eaux troubles. Les coordonnées sont cryptées.',
                'content' => 'Nord : Racine carrée de 144\nEst : Deux douzaines\nQuelle est la somme des coordonnées ?',
                'answer' => '36',
                'points' => 25,
                'difficulty' => 2,
                'hint' => 'Simplifiez : √144 = 12, et deux douzaines = 24. Maintenant additionnez.'
            ],
            [
                'title' => 'Le Rhum du Sage',
                'description' => 'Une bouteille de rhum contient un message secret. Le liquide agit comme une loupe.',
                'content' => 'Dans une bouteille de rhum, il y a 3 verres. Dans chaque verre, il y a 3 gouttes. Dans chaque goutte, il y a 3 secrets. Combien y a-t-il de secrets au total ?',
                'answer' => '27',
                'points' => 35,
                'difficulty' => 3,
                'hint' => 'Multipliez par 3 à chaque niveau : bouteille → verres → gouttes → secrets'
            ],
            [
                'title' => 'L\'Épée Chantante',
                'description' => 'Cette épée vibre d\'une mélodie particulière. Chaque note cache un chiffre.',
                'content' => 'DO = 1, RE = 2, MI = 3\nLa mélodie joue : DO-MI-RE-MI\nQuel est le code ?',
                'answer' => '1323',
                'points' => 15,
                'difficulty' => 1,
                'hint' => 'Remplacez simplement chaque note par son chiffre correspondant.'
            ]
        ];

        foreach ($enigmas as $enigma) {
            DB::table('enigmas')->insert($enigma);
        }
    }

    public function down()
    {
        // Optionnel : supprimer les énigmes ajoutées
        DB::table('enigmas')->whereIn('title', [
            'Le Perroquet Bavard',
            'La Longue-Vue du Capitaine',
            'L\'Ancre Perdue',
            'Le Rhum du Sage',
            'L\'Épée Chantante'
        ])->delete();
    }
};
