<?php

namespace Database\Seeders;

use App\Models\Enigma;
use Illuminate\Database\Seeder;

class EnigmaSeeder extends Seeder
{
    public function run()
    {
        $enigmas = [
            [
                'title' => 'Le Message du Capitaine',
                'description' => 'Un message mystérieux laissé par le capitaine Morgan avant sa disparition.',
                'content' => "Je suis le début de l'océan, mais pas de la mer.\nJe termine la plage, mais pas le sable.\nJe suis dans le navire, mais pas dans le bateau.\nQui suis-je ?",
                'answer' => 'n',
                'hint1' => 'Regardez attentivement chaque mot et leurs lettres.',
                'hint2' => 'Cette lettre apparaît dans certains mots mais pas dans d\'autres.',
                'hint3' => 'C\'est une seule lettre qui fait la différence.',
                'fragment' => 'NORD',
                'points' => 100,
                'difficulty' => 2,
                'image_path' => '/images/enigmas/message.jpg',
                'order' => 1
            ],
            [
                'title' => 'La Carte aux Trésors',
                'description' => 'Une énigme basée sur une ancienne carte au trésor.',
                'content' => "Quand le soleil est à son zénith,\nCompte les pas vers l'est depuis le grand chêne,\nMais attention au nombre caché :\nJe suis le produit de la première paire de chiffres premiers.",
                'answer' => '6',
                'hint1' => 'Les premiers nombres premiers sont 2 et 3.',
                'hint2' => 'Il faut faire une multiplication.',
                'hint3' => '2 × 3 = ?',
                'fragment' => 'EST',
                'points' => 150,
                'difficulty' => 1,
                'image_path' => '/images/enigmas/map.jpg',
                'order' => 2
            ],
            [
                'title' => 'Le Code du Coffre',
                'description' => 'Un mystérieux coffre avec un mécanisme de verrouillage complexe.',
                'content' => "Sur le coffre sont gravés ces symboles :\n = 2\n = 4\n = 6\n = ?\n\nSi  +  = 6\nEt  +  = 10\nAlors  = ?",
                'answer' => '8',
                'hint1' => 'Observez la progression des nombres.',
                'hint2' => 'Chaque symbole augmente de 2.',
                'hint3' => 'La suite est : 2, 4, 6, ...',
                'fragment' => 'TRESOR',
                'points' => 200,
                'difficulty' => 3,
                'image_path' => '/images/enigmas/chest.jpg',
                'order' => 3
            ],
            [
                'title' => 'Les Coordonnées Secrètes',
                'description' => 'Un parchemin contenant des coordonnées mystérieuses.',
                'content' => "Dans un système où A=1, B=2, C=3...\nLe point se trouve à :\nH + G + I = Latitude\nJ + K + L = Longitude\n\nQuelle est la latitude ?",
                'answer' => '24',
                'hint1' => 'H est la 8ème lettre de l\'alphabet',
                'hint2' => 'G est la 7ème lettre, I est la 9ème lettre',
                'hint3' => '8 + 7 + 9 = ?',
                'fragment' => 'CARTE',
                'points' => 250,
                'difficulty' => 2,
                'image_path' => '/images/enigmas/coordinates.jpg',
                'order' => 4
            ],
            [
                'title' => 'Le Cadran Solaire',
                'description' => 'Un ancien cadran solaire avec des inscriptions énigmatiques.',
                'content' => "À midi, l'ombre pointe vers le nord\nÀ 15h, elle indique l'ouest\nÀ quelle heure pointe-t-elle vers l'est ?",
                'answer' => '9',
                'hint1' => 'Le soleil fait un tour complet en 24 heures',
                'hint2' => 'De midi à 15h, l\'ombre parcourt 90 degrés',
                'hint3' => 'Pour aller vers l\'est, il faut reculer de 3 heures depuis midi',
                'fragment' => 'SOLEIL',
                'points' => 300,
                'difficulty' => 4,
                'image_path' => '/images/enigmas/sundial.jpg',
                'order' => 5
            ],
            [
                'title' => 'Le Chant des Sirènes',
                'description' => 'Une mélodie mystérieuse qui cache un message codé.',
                'content' => "DO RE MI FA SOL LA SI\n_ _ _ _ _ _ _\n\nLe message caché suit cette règle :\n1er = 3ème note\n2ème = 5ème note\n3ème = 1ère note\n4ème = 6ème note\n5ème = 2ème note\n6ème = 4ème note\n7ème = 7ème note\n\nQuelle est la 3ème note du message ?",
                'answer' => 'do',
                'hint1' => 'Écrivez les notes dans l\'ordre donné',
                'hint2' => 'La 3ème note est égale à la 1ère note de la gamme',
                'hint3' => 'DO est la première note de la gamme',
                'fragment' => 'MELODIE',
                'points' => 350,
                'difficulty' => 5,
                'image_path' => '/images/enigmas/siren.jpg',
                'order' => 6
            ]
        ];

        foreach ($enigmas as $enigma) {
            Enigma::create($enigma);
        }
    }
}
