<?php

use App\Models\User;
use App\Models\Enigma;
use App\Models\UserProgress;
use App\Models\UserFragment;
use App\Models\Winner;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    // Nettoyer les tables pour repartir de zéro en utilisant delete() au lieu de truncate()
    Winner::query()->delete();
    UserFragment::query()->delete();
    UserProgress::query()->delete();
    Enigma::query()->delete();

    // Créer un utilisateur pour les tests
    $this->user = User::factory()->create([
        'points' => 0
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
        'order' => 1
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
        'order' => 2
    ]);
});

test('validate correct answer', function () {
    Sanctum::actingAs($this->user);

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
});

test('validate incorrect answer', function () {
    Sanctum::actingAs($this->user);

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
});

test('get hint', function () {
    Sanctum::actingAs($this->user);

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

test('get user fragments', function () {
    Sanctum::actingAs($this->user);

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
});

test('validate treasure code without completing all enigmas', function () {
    Sanctum::actingAs($this->user);

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
    Sanctum::actingAs($this->user);

    // Résoudre la première énigme via l’API
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

    // Vérifier qu’un fragment a été généré
    $this->assertDatabaseHas('user_fragments', [
        'user_id' => $this->user->id,
        'enigma_id' => $this->enigma1->id
    ]);

    // Résoudre la deuxième énigme via l’API
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

    // Vérifier qu’un fragment a été généré
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

    // Vérifier que l’utilisateur est enregistré comme gagnant
    $this->assertDatabaseHas('winners', [
        'user_id' => $this->user->id,
        'treasure_hunt_id' => 1,
        'rank' => 1
    ]);
});
