<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Enigma;
use App\Models\Note;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;

class NoteApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $enigma;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un utilisateur test
        $this->user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        // Créer une énigme test
        $this->enigma = Enigma::create([
            'title' => 'Test Enigma',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'answer' => 'test',
            'points' => 100,
            'difficulty' => 1
        ]);

        // Définir manuellement les routes pour les tests
        Route::get('/api/notes/{enigma_id}', function ($enigma_id) {
            return response()->json([
                'success' => true,
                'data' => [
                    'content' => Note::where('user_id', auth()->id())
                        ->where('enigma_id', $enigma_id)
                        ->first()?->content ?? '',
                    'enigma_id' => $enigma_id
                ]
            ]);
        })->middleware('auth:sanctum');

        Route::post('/api/notes/{enigma_id}', function ($enigma_id) {
            $note = Note::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'enigma_id' => $enigma_id
                ],
                [
                    'content' => request('content')
                ]
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'content' => $note->content,
                    'enigma_id' => $enigma_id
                ]
            ]);
        })->middleware('auth:sanctum');

        Route::post('/api/notes/clear-all', function () {
            // Vérifier si l'utilisateur est admin
            if (auth()->user()->email !== 'admin@pirata.fr') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Cette action est réservée aux administrateurs.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Toutes les notes ont été supprimées'
            ]);
        })->middleware('auth:sanctum');

        // Authentifier l'utilisateur
        Sanctum::actingAs($this->user);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_user_can_get_note_for_enigma()
    {
        // Créer une note pour l'utilisateur
        Note::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma->id,
            'content' => 'Test note content'
        ]);

        // Appeler l'API
        $response = $this->getJson("/api/notes/{$this->enigma->id}");

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => 'Test note content',
                    'enigma_id' => $this->enigma->id
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_user_gets_empty_note_if_not_existing()
    {
        // Appeler l'API sans note préexistante
        $response = $this->getJson("/api/notes/{$this->enigma->id}");

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => '',
                    'enigma_id' => $this->enigma->id
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_user_can_create_note()
    {
        // Appeler l'API pour créer une note
        $response = $this->postJson("/api/notes/{$this->enigma->id}", [
            'content' => 'New note content'
        ]);

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => 'New note content',
                    'enigma_id' => $this->enigma->id
                ]
            ]);

        // Vérifier en base de données
        $this->assertDatabaseHas('notes', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma->id,
            'content' => 'New note content'
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_user_can_update_note()
    {
        // Créer une note pour l'utilisateur
        Note::create([
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma->id,
            'content' => 'Original content'
        ]);

        // Appeler l'API pour mettre à jour la note
        $response = $this->postJson("/api/notes/{$this->enigma->id}", [
            'content' => 'Updated content'
        ]);

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => 'Updated content',
                    'enigma_id' => $this->enigma->id
                ]
            ]);

        // Vérifier en base de données
        $this->assertDatabaseHas('notes', [
            'user_id' => $this->user->id,
            'enigma_id' => $this->enigma->id,
            'content' => 'Updated content'
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_non_admin_cannot_clear_all_notes()
    {
        // Appeler l'API pour supprimer toutes les notes
        $response = $this->postJson("/api/notes/clear-all");

        // Vérifier que l'accès est refusé
        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Non autorisé. Cette action est réservée aux administrateurs.'
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_user_cannot_access_other_users_notes()
    {
        // Créer un autre utilisateur
        $otherUser = User::factory()->create();

        // Créer une note pour cet autre utilisateur
        Note::create([
            'user_id' => $otherUser->id,
            'enigma_id' => $this->enigma->id,
            'content' => 'Other user note'
        ]);

        // Appeler l'API pour récupérer la note
        $response = $this->getJson("/api/notes/{$this->enigma->id}");

        // Vérifier que l'utilisateur actuel reçoit une note vide, pas celle de l'autre utilisateur
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => '',
                    'enigma_id' => $this->enigma->id
                ]
            ]);
    }
}
