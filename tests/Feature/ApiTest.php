<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Enigma;
use App\Models\UserProgress;
use App\Models\UserFragment;
use App\Models\Winner;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // tables pour repartir de zéro
        Winner::query()->delete();
        UserFragment::query()->delete();
        UserProgress::query()->delete();
        Enigma::query()->delete();

        // utilisateur pour les tests
        $this->user = User::factory()->create([
            'points' => 0,
            'email_verified_at' => now()
        ]);

        //  énigmes 1
        $this->enigma1 = Enigma::create([
            'title' => 'Première énigme',
            'description' => 'Description de la première énigme',
            'content' => 'Contenu de la première énigme',
            'answer' => 'réponse1',
            'hint1' => 'Indice 1 pour énigme 1',
            'hint2' => 'Indice 2 pour énigme 1',
            'hint3' => 'Indice 3 pour énigme 1',
            'points' => 100,
            'difficulty' => 1,
            'order' => 1,
            'fragment' => 'FRAG1'
        ]);

        //  énigmes 2
        $this->enigma2 = Enigma::create([
            'title' => 'Deuxième énigme',
            'description' => 'Description de la deuxième énigme',
            'content' => 'Contenu de la deuxième énigme',
            'answer' => 'réponse2',
            'hint1' => 'Indice 1 pour énigme 2',
            'hint2' => 'Indice 2 pour énigme 2',
            'hint3' => 'Indice 3 pour énigme 2',
            'points' => 200,
            'difficulty' => 2,
            'order' => 2,
            'fragment' => 'FRAG2'
        ]);

        // Authentifier l'utilisateur
        Sanctum::actingAs($this->user);
    }

    // Tests de structure de réponse API
    public function test_api_success_response_structure()
    {
        $response = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'réponse1'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'attempts',
                    'points_earned',
                    'fragment',
                    'time_spent',
                    'completed'
                ]
            ])
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_api_error_response_structure()
    {
        $response = $this->postJson('/api/treasure/validate', [
            'code' => 'invalid-code'
        ]);

        $response->assertJsonStructure([
            'success',
            'message',
            'errors'
        ])
        ->assertJson([
            'success' => false
        ]);
    }

    // Tests de validation de réponse
    public function test_validate_correct_answer()
    {
        $response = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'réponse1'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'completed' => true
                ]
            ]);

        // Vérification l'utilisateur reçu les points
        $this->user->refresh();
        $this->assertEquals(100, $this->user->points);

        // Vérification la progression enregistrée
        $this->assertDatabaseHas('user_progress', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'completed' => true
        ]);

        // Vérification le fragment créé
        $this->assertDatabaseHas('user_fragments', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id
        ]);

        // Vérification le fragment est non vide
        $fragment = UserFragment::where('user_id', $this->user->id)
            ->where('enigma_id', $this->enigma1->id)
            ->first();
        $this->assertNotEmpty($fragment->fragment);
    }

    public function test_validate_incorrect_answer()
    {
        $response = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'mauvaise réponse'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,  // Changé de false à true
                'message' => 'Ce n\'est pas la bonne réponse. Essayez encore !',
                'data' => [
                    'completed' => false
                ]
            ]);

        // Vérification l'utilisateur n'a pas reçu de points
        $this->user->refresh();
        $this->assertEquals(0, $this->user->points);

        // Vérification la tentative enregistrée
        $this->assertDatabaseHas('user_progress', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'attempts' => 1,
            'completed' => false
        ]);

        // Vérification aucun fragment n'a été créé
        $this->assertDatabaseMissing('user_fragments', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id
        ]);
    }

    public function test_validate_answer_with_special_characters()
    {
        // énigme avec une réponse contenant des caractères spéciaux
        $enigmaSpecial = Enigma::create([
            'title' => 'Énigme spéciale',
            'description' => 'Description de l\'énigme spéciale',
            'content' => 'Contenu de l\'énigme spéciale',
            'answer' => 'ré-ponse!@#$%^&*',
            'hint1' => 'Indice 1',
            'points' => 150,
            'difficulty' => 2,
            'order' => 3
        ]);

        $response = $this->postJson("/api/enigmas/{$enigmaSpecial->id}/validate", [
            'answer' => 'ré-ponse!@#$%^&*'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'completed' => true
                ]
            ]);
    }

    // Tests pour les indices
    public function test_get_hint()
    {
        $response = $this->getJson("/api/enigmas/{$this->enigma1->id}/hint/1");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'hint' => 'Indice 1 pour énigme 1',
                    'hint_number' => 1
                ]
            ]);

        // Vérification l'indice a marqué comme utilisé
        $this->assertDatabaseHas('user_progress', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'hints_used' => 1
        ]);
    }

    public function test_get_second_hint_requires_first_hint()
    {
        // Tenter d'obtenir le deuxième indice sans avoir demandé le premier
        $response = $this->getJson("/api/enigmas/{$this->enigma1->id}/hint/2");

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Vous devez d\'abord utiliser les indices précédents'
            ]);
    }

    // Tests pour les fragments
    public function test_get_user_fragments()
    {
        // Créer un fragment pour l'utilisateur
        UserFragment::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'fragment' => 'ABC',
            'fragment_order' => 1
        ]);

        $response = $this->getJson('/api/user/fragments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'fragments',
                    'all_completed',
                    'progress' => [
                        'total',
                        'completed',
                        'percentage'
                    ]
                ]
            ]);

        // Vérifier que le fragment est bien inclus dans la réponse
        $this->assertStringContainsString('ABC', $response->getContent());
    }

    public function test_generate_unique_fragment()
    {
        // Test de génération de fragment unique
        $response = $this->postJson('/api/fragments/generate', [
            'enigma_id' => $this->enigma1->id
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'fragment',
                    'enigma_id'
                ]
            ]);
    }

    // Tests pour la validation du code trésor
    public function test_validate_treasure_code_without_completing_all_enigmas()
    {
        // Marquer seulement la première énigme comme complétée
        UserProgress::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'completed' => true,
            'completed_at' => now()
        ]);

        // Créer un fragment pour l'utilisateur
        UserFragment::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'fragment' => 'ABC',
            'fragment_order' => 1
        ]);

        $response = $this->postJson('/api/treasure/validate', [
            'code' => 'ABC'
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Vous devez résoudre toutes les énigmes d\'abord !'
            ]);
    }

    public function test_validate_treasure_code_after_completing_all_enigmas()
    {
        // Résoudre les énigmes via l'API
        $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'réponse1'
        ]);

        $this->postJson("/api/enigmas/{$this->enigma2->id}/validate", [
            'answer' => 'réponse2'
        ]);

        // Récupérer les fragments générés pour construire le code
        $fragments = UserFragment::where('user_id', $this->user->id)
            ->orderBy('fragment_order')
            ->pluck('fragment')
            ->implode('-');

        // Valider le code du trésor
        $response = $this->postJson('/api/treasure/validate', [
            'code' => $fragments
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'rank' => 1,
                    'is_first_winner' => true
                ]
            ]);

        // Vérifier que l'utilisateur est enregistré comme gagnant
        $this->assertDatabaseHas('winners', [
            'user_id' => $this->user->id,
            'treasure_hunt_id' => 1,
            'rank' => 1
        ]);
    }

    public function test_validate_treasure_code_with_incorrect_format()
    {
        // Résoudre toutes les énigmes
        UserProgress::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'completed' => true,
            'completed_at' => now()
        ]);

        UserProgress::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma2->id,
            'completed' => true,
            'completed_at' => now()
        ]);

        // Créer des fragments
        UserFragment::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma1->id,
            'fragment' => 'ABC',
            'fragment_order' => 1
        ]);

        UserFragment::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma2->id,
            'fragment' => 'DEF',
            'fragment_order' => 2
        ]);

        // Soumettre un code incorrect
        $response = $this->postJson('/api/treasure/validate', [
            'code' => 'ABC-XYZ'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Ce n\'est pas le bon code. Vérifiez l\'ordre de vos fragments.'
            ]);
    }

    public function test_fragment_uniqueness_for_same_user_and_enigma()
    {
        // Résoudre l'énigme une première fois
        $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'réponse1'
        ]);

        // Récupérer le fragment généré
        $fragment1 = UserFragment::where('user_id', $this->user->id)
            ->where('enigma_id', $this->enigma1->id)
            ->first()->fragment;

        // Supprimer manuellement la progression pour simuler une nouvelle tentative
        UserProgress::where('user_id', $this->user->id)->delete();
        UserFragment::where('user_id', $this->user->id)->delete();

        // Résoudre l'énigme une seconde fois
        $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
            'answer' => 'réponse1'
        ]);

        // Récupérer le nouveau fragment
        $fragment2 = UserFragment::where('user_id', $this->user->id)
            ->where('enigma_id', $this->enigma1->id)
            ->first()->fragment;

        // Vérifier que le même fragment est généré
        $this->assertEquals($fragment1, $fragment2);
    }
}
