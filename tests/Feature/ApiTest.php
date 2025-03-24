<?php

use App\Models\User;
use App\Models\Enigma;
use App\Models\UserProgress;
use App\Models\UserFragment;
use App\Models\Winner;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // Commencer une transaction pour assurer l'isolation des tests
    DB::beginTransaction();

    // Nettoyer les tables pour repartir de zéro en utilisant delete() au lieu de truncate()
    Winner::query()->delete();
    UserFragment::query()->delete();
    UserProgress::query()->delete();
    Enigma::query()->delete();

    // Créer un utilisateur pour les tests
    $this->user = User::factory()->create([
        'points' => 0,
        'email_verified_at' => now() // S'assurer que l'utilisateur est vérifié
    ]);

    // Créer deux énigmes pour les tests
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
        'fragment' => 'FRAG1' // Ajout d'un fragment par défaut pour la migration, si nécessaire
    ]);

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
        'fragment' => 'FRAG2' // Ajout d'un fragment par défaut pour la migration, si nécessaire
    ]);

    // Authentifier l'utilisateur pour tous les tests
    Sanctum::actingAs($this->user);
});

afterEach(function () {
    // Annuler la transaction pour ne pas affecter d'autres tests
    DB::rollBack();
});

test('validate correct answer', function () {
    $response = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
        'answer' => 'réponse1'
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'completed' => true
        ]);

    // Vérifier que l'utilisateur a reçu les points
    $this->user->refresh();
    expect($this->user->points)->toBe(100);

    // Vérifier que la progression a été enregistrée
    $this->assertDatabaseHas('user_progress', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id,
        'completed' => true
    ]);

    // Vérifier qu'un fragment a été créé
    $this->assertDatabaseHas('user_fragments', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id
    ]);

    // Vérifier que le fragment est non vide
    $fragment = UserFragment::where('user_id', $this->user->id)
        ->where('enigma_id', $this->enigma1->id)
        ->first();
    expect($fragment->fragment)->not->toBeEmpty();
});

test('validate incorrect answer', function () {
    $response = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
        'answer' => 'mauvaise réponse'
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => false
        ]);

    // Vérifier que l'utilisateur n'a pas reçu de points
    $this->user->refresh();
    expect($this->user->points)->toBe(0);

    // Vérifier que la tentative a été enregistrée
    $this->assertDatabaseHas('user_progress', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id,
        'attempts' => 1,
        'completed' => false
    ]);

    // Vérifier qu'aucun fragment n'a été créé
    $this->assertDatabaseMissing('user_fragments', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id
    ]);
});

test('validate answer with special characters', function () {
    // Créer une énigme avec une réponse contenant des caractères spéciaux
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
            'completed' => true
        ]);
});

test('get hint', function () {
    $response = $this->getJson("/api/enigmas/{$this->enigma1->id}/hint/1");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'hint' => 'Indice 1 pour énigme 1'
        ]);

    // Vérifier que l'indice a été marqué comme utilisé
    $this->assertDatabaseHas('user_progress', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id,
        'hints_used' => 1
    ]);
});

test('get second hint requires first hint', function () {
    // Tenter d'obtenir le deuxième indice sans avoir demandé le premier
    $response = $this->getJson("/api/enigmas/{$this->enigma1->id}/hint/2");

    $response->assertStatus(403)
        ->assertJson([
            'success' => false,
            'message' => 'Vous devez d\'abord utiliser les indices précédents'
        ]);
});

test('get user fragments', function () {
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
            'fragments',
            'all_completed',
            'progress' => [
                'total',
                'completed',
                'percentage'
            ]
        ]);

    // Vérifier que le fragment est bien inclus dans la réponse
    $response->assertJsonPath('fragments.0.fragment', 'ABC');
});

test('validate treasure code without completing all enigmas', function () {
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
});

test('validate treasure code after completing all enigmas', function () {
    // Résoudre la première énigme via l'API
    $response1 = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
        'answer' => 'réponse1'
    ]);
    $response1->assertStatus(200)
        ->assertJson([
            'success' => true,
            'completed' => true
        ]);

    // Vérifier que UserProgress a bien été mis à jour
    $this->assertDatabaseHas('user_progress', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id,
        'completed' => true
    ]);

    // Vérifier qu'un fragment a été généré
    $this->assertDatabaseHas('user_fragments', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id
    ]);

    // Résoudre la deuxième énigme via l'API
    $response2 = $this->postJson("/api/enigmas/{$this->enigma2->id}/validate", [
        'answer' => 'réponse2'
    ]);
    $response2->assertStatus(200)
        ->assertJson([
            'success' => true,
            'completed' => true
        ]);

    // Vérifier que UserProgress a bien été mis à jour
    $this->assertDatabaseHas('user_progress', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma2->id,
        'completed' => true
    ]);

    // Vérifier qu'un fragment a été généré
    $this->assertDatabaseHas('user_fragments', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma2->id
    ]);

    // Vérifier le nombre total d'énigmes et d'énigmes complétées
    $totalEnigmas = Enigma::count();
    $completedEnigmas = UserProgress::where('user_id', $this->user->id)
        ->where('completed', true)
        ->count();
    expect($totalEnigmas)->toBe($completedEnigmas);

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
            'rank' => 1,
            'is_first_winner' => true,
        ]);

    // Vérifier que l'utilisateur est enregistré comme gagnant
    $this->assertDatabaseHas('winners', [
        'user_id' => $this->user->id,
        'treasure_hunt_id' => 1,
        'rank' => 1
    ]);
});

test('validate treasure code with incorrect format', function () {
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
});

test('fragment uniqueness for same user and enigma', function () {
    // Résoudre l'énigme une première fois
    $response1 = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
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
    $response2 = $this->postJson("/api/enigmas/{$this->enigma1->id}/validate", [
        'answer' => 'réponse1'
    ]);

    // Récupérer le nouveau fragment
    $fragment2 = UserFragment::where('user_id', $this->user->id)
        ->where('enigma_id', $this->enigma1->id)
        ->first()->fragment;

    // Vérifier que le même fragment est généré
    expect($fragment1)->toBe($fragment2);
});
