<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Enigma;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chapitre 1
        $chapter1 = Chapter::create([
            'title' => 'Le Début de l\'Aventure',
            'description' => 'Le début de votre quête pour trouver le trésor perdu du Capitaine Morgan.',
            'story_content' => 'Vous vous trouvez sur une île mystérieuse, suivant les traces d\'un légendaire trésor pirate.',
            'order' => 1,
            'location' => 'Île Mystérieuse',
            'weather_condition' => 'Ensoleillé',
            'required_items' => json_encode(['boussole', 'carte']),
        ]);

        // Chapitre 2
        $chapter2 = Chapter::create([
            'title' => 'Les Grottes Secrètes',
            'description' => 'Explorez les grottes mystérieuses de l\'île pour découvrir de nouveaux indices.',
            'story_content' => 'Les grottes abritent d\'anciens secrets et peut-être une partie du trésor.',
            'order' => 2,
            'location' => 'Grottes Côtières',
            'weather_condition' => 'Nuageux',
            'required_items' => json_encode(['torche', 'corde']),
        ]);

        // Chapitre 3
        $chapter3 = Chapter::create([
            'title' => 'Le Temple Perdu',
            'description' => 'Un ancien temple maya cache des secrets millénaires.',
            'story_content' => 'Le temple renferme des pièges mortels et des énigmes complexes.',
            'order' => 3,
            'location' => 'Temple Maya',
            'weather_condition' => 'Pluvieux',
            'required_items' => json_encode(['machette', 'gourde']),
        ]);

        // Énigmes du Chapitre 1
        Enigma::create([
            'title' => 'Le Message du Capitaine',
            'description' => 'Un message mystérieux laissé par le capitaine Morgan avant sa disparition.',
            'content' => 'Déchiffrez le message codé laissé par le Capitaine Morgan.',
            'answer' => 'TRESOR',
            'hint1' => 'Regardez les premières lettres',
            'hint2' => 'Le message contient un code simple',
            'hint3' => 'Utilisez l\'alphabet inverse',
            'fragment' => 'T1',
            'points' => 100,
            'difficulty' => 2,
            'order' => 1,
            'chapter_id' => $chapter1->id,
        ]);

        Enigma::create([
            'title' => 'La Carte aux Trésors',
            'description' => 'Une énigme basée sur une ancienne carte du trésor.',
            'content' => 'Trouvez les coordonnées cachées dans cette ancienne carte.',
            'answer' => 'N23W45',
            'hint1' => 'Les symboles sur la carte sont importants',
            'hint2' => 'Cherchez les points cardinaux',
            'hint3' => 'Combinez les chiffres trouvés',
            'fragment' => 'T2',
            'points' => 150,
            'difficulty' => 3,
            'order' => 2,
            'chapter_id' => $chapter1->id,
        ]);

        Enigma::create([
            'title' => 'Le Code du Coffre',
            'description' => 'Un mystérieux coffre avec un mécanisme de verrouillage complexe.',
            'content' => 'Résolvez le mécanisme pour ouvrir le coffre au trésor.',
            'answer' => '1742',
            'hint1' => 'Les symboles sur le coffre sont une séquence',
            'hint2' => 'Chaque symbole représente un chiffre',
            'hint3' => 'L\'ordre est important',
            'fragment' => 'T3',
            'points' => 200,
            'difficulty' => 4,
            'order' => 3,
            'chapter_id' => $chapter1->id,
        ]);

        // Énigmes du Chapitre 2
        Enigma::create([
            'title' => 'Les Symboles de la Grotte',
            'description' => 'Des symboles mystérieux gravés sur les parois de la grotte.',
            'content' => 'Décryptez les symboles anciens pour révéler leur message.',
            'answer' => 'LUMIERE',
            'hint1' => 'Les symboles forment des mots',
            'hint2' => 'Certains symboles se répètent',
            'hint3' => 'Pensez aux éléments naturels',
            'fragment' => 'T4',
            'points' => 250,
            'difficulty' => 3,
            'order' => 1,
            'chapter_id' => $chapter2->id,
        ]);

        Enigma::create([
            'title' => 'L\'Énigme du Puits',
            'description' => 'Un puits ancien avec des mécanismes complexes.',
            'content' => 'Activez le mécanisme du puits dans le bon ordre.',
            'answer' => 'EAUROCHEVENT',
            'hint1' => 'Les éléments sont la clé',
            'hint2' => 'L\'ordre naturel est important',
            'hint3' => 'Pensez au cycle de l\'eau',
            'fragment' => 'T5',
            'points' => 300,
            'difficulty' => 4,
            'order' => 2,
            'chapter_id' => $chapter2->id,
        ]);

        // Énigmes du Chapitre 3
        Enigma::create([
            'title' => 'Les Glyphes Mayas',
            'description' => 'Des glyphes mayas anciens cachent un message important.',
            'content' => 'Traduisez les glyphes pour découvrir le message secret.',
            'answer' => 'SOLEIL',
            'hint1' => 'Les glyphes représentent des concepts',
            'hint2' => 'Le cycle solaire est important',
            'hint3' => 'Regardez l\'orientation des symboles',
            'fragment' => 'T6',
            'points' => 350,
            'difficulty' => 5,
            'order' => 1,
            'chapter_id' => $chapter3->id,
        ]);

        Enigma::create([
            'title' => 'Le Calendrier Sacré',
            'description' => 'Un calendrier maya complexe cache un secret.',
            'content' => 'Trouvez la date qui révélera l\'emplacement du trésor.',
            'answer' => '21121221',
            'hint1' => 'La date est liée aux solstices',
            'hint2' => 'Les chiffres forment un motif',
            'hint3' => 'Pensez au cycle maya',
            'fragment' => 'T7',
            'points' => 400,
            'difficulty' => 5,
            'order' => 2,
            'chapter_id' => $chapter3->id,
        ]);
    }
}
