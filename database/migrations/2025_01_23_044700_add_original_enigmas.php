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
                'title' => 'Le Secret du Coffre',
                'description' => 'Un vieux coffre aux trésors avec un mécanisme complexe attend d\'être ouvert.',
                'content' => 'Le coffre ne s\'ouvrira que si vous trouvez la bonne combinaison. Indice : 2 + 3 = 10, 3 + 7 = 27, 4 + 5 = ?',
                'answer' => '20',
                'points' => 20,
                'difficulty' => 2,
                'hint' => 'Regardez comment les nombres sont transformés dans les deux premiers exemples.',
                'image_path' => null
            ],
            [
                'title' => 'La Carte Mystérieuse',
                'description' => 'Une carte ancienne cache les coordonnées d\'un trésor légendaire.',
                'content' => 'Sur la carte, vous voyez ces symboles : ◊□○△. Si ◊=1, □=2, ○=3, alors △=?',
                'answer' => '4',
                'points' => 15,
                'difficulty' => 1,
                'hint' => 'Observez la séquence des symboles et leur progression.',
                'image_path' => null
            ],
            [
                'title' => 'La Boussole Enchantée',
                'description' => 'Une boussole magique qui pointe vers votre destin.',
                'content' => 'La boussole tourne trois fois vers la droite, puis deux fois vers la gauche. Si N=1, E=2, S=3, O=4, quelle direction indique-t-elle ?',
                'answer' => '2',
                'points' => 25,
                'difficulty' => 2,
                'hint' => 'Suivez les rotations pas à pas en partant du Nord.',
                'image_path' => null
            ],
            [
                'title' => 'Le Navire Fantôme',
                'description' => 'Un navire mystérieux apparaît dans la brume.',
                'content' => 'Le navire compte 12 canons à tribord, 8 à bâbord. La moitié des canons sont chargés. Combien de boulets peuvent être tirés ?',
                'answer' => '10',
                'points' => 30,
                'difficulty' => 3,
                'hint' => 'Additionnez tous les canons puis prenez la moitié.',
                'image_path' => null
            ],
            [
                'title' => 'Le Crâne Parlant',
                'description' => 'Un crâne ancien qui murmure des énigmes aux visiteurs.',
                'content' => 'Le crâne dit : "Je suis ce que je suis, mais je ne suis pas ce que je suis. Si j\'étais ce que je suis, je ne serais pas ce que je suis." Que suis-je ?',
                'answer' => 'OMBRE',
                'points' => 40,
                'difficulty' => 4,
                'hint' => 'Pensez à ce qui vous suit toujours mais n\'est jamais vraiment vous.',
                'image_path' => null
            ]
        ];

        foreach ($enigmas as $enigma) {
            DB::table('enigmas')->insert([
                'title' => $enigma['title'],
                'description' => $enigma['description'],
                'content' => $enigma['content'],
                'answer' => $enigma['answer'],
                'points' => $enigma['points'],
                'difficulty' => $enigma['difficulty'],
                'hint1' => $enigma['hint'],
                'image_path' => $enigma['image_path'],
                'chapter_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        DB::table('enigmas')->where('chapter_id', 1)->delete();
    }
};
