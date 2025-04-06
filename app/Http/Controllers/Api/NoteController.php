<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use App\Models\Enigma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    /**
     * Récupérer les notes d'un utilisateur pour une énigme spécifique.
     *
     * @param  int  $enigmaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($enigmaId)
    {
        try {
            // Vérifier que l'énigme existe
            $enigma = Enigma::findOrFail($enigmaId);

            // Récupérer l'utilisateur authentifié
            $user = Auth::user() ?? request()->user();

            // Récupérer la note (ou null si elle n'existe pas)
            $note = Note::where('user_id', $user->id)
                ->where('enigma_id', $enigmaId)
                ->first();

            return ApiResource::success([
                'content' => $note ? $note->content : '',
                'enigma_id' => $enigmaId,
                'enigma_title' => $enigma->title,
                'updated_at' => $note ? $note->updated_at : null
            ], 'Notes récupérées avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des notes', [
                'enigma_id' => $enigmaId,
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la récupération des notes',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Créer ou mettre à jour les notes d'un utilisateur pour une énigme.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $enigmaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request, $enigmaId)
    {
        try {
            $request->validate([
                'content' => 'nullable|string',
            ]);

            // Vérifier que l'énigme existe
            $enigma = Enigma::findOrFail($enigmaId);

            // Récupérer l'utilisateur authentifié
            $user = Auth::user() ?? $request->user();

            // Créer ou mettre à jour la note
            $note = Note::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'enigma_id' => $enigmaId
                ],
                [
                    'content' => $request->content
                ]
            );

            return ApiResource::success([
                'content' => $note->content,
                'enigma_id' => $enigmaId,
                'enigma_title' => $enigma->title,
                'updated_at' => $note->updated_at
            ], 'Notes enregistrées avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement des notes', [
                'enigma_id' => $enigmaId,
                'user_id' => Auth::id(),
                'content' => $request->content,
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de l\'enregistrement des notes',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Supprimer toutes les notes d'un utilisateur (réservé à un admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAll(Request $request)
    {
        try {
            // Vérifier si l'utilisateur est admin (email admin@pirata.fr)
            $user = Auth::user() ?? $request->user();
            if ($user->email !== 'admin@pirata.fr') {
                return ApiResource::error(
                    'Non autorisé. Cette action est réservée aux administrateurs.',
                    null,
                    403
                );
            }

            // Supprimer les notes selon les paramètres
            if ($request->has('user_id')) {
                // Vérifier que l'utilisateur existe
                $targetUser = \App\Models\User::find($request->user_id);
                if (!$targetUser) {
                    return ApiResource::error(
                        'Utilisateur non trouvé',
                        null,
                        404
                    );
                }

                // Supprimer les notes d'un utilisateur spécifique
                $count = Note::where('user_id', $request->user_id)->delete();
                $message = "Les notes de l'utilisateur ont été supprimées ({$count} notes)";
            } elseif ($request->has('enigma_id')) {
                // Vérifier que l'énigme existe
                $enigma = Enigma::find($request->enigma_id);
                if (!$enigma) {
                    return ApiResource::error(
                        'Énigme non trouvée',
                        null,
                        404
                    );
                }

                // Supprimer les notes pour une énigme spécifique
                $count = Note::where('enigma_id', $request->enigma_id)->delete();
                $message = "Les notes pour l'énigme ont été supprimées ({$count} notes)";
            } else {
                // Supprimer toutes les notes
                $count = Note::count();
                Note::truncate();
                $message = "Toutes les notes ont été supprimées ({$count} notes)";
            }

            // Enregistrer l'action dans les logs
            Log::info('Notes supprimées par admin', [
                'admin_id' => $user->id,
                'admin_email' => $user->email,
                'params' => $request->all()
            ]);

            return ApiResource::success([
                'count' => $count ?? 0
            ], $message);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression des notes', [
                'admin_id' => Auth::id(),
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la suppression des notes',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Récupérer toutes les notes d'un utilisateur (pour la synchronisation).
     * Cette méthode pourrait être utile pour les applications mobiles qui ont besoin
     * de synchroniser toutes les notes d'un utilisateur en une seule requête.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNotes(Request $request)
    {
        try {
            $user = Auth::user() ?? $request->user();

            // Récupérer toutes les notes de l'utilisateur avec les énigmes associées
            $notes = Note::where('user_id', $user->id)
                ->with('enigma:id,title')
                ->get()
                ->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'enigma_id' => $note->enigma_id,
                        'enigma_title' => $note->enigma->title ?? 'Énigme inconnue',
                        'content' => $note->content,
                        'updated_at' => $note->updated_at
                    ];
                });

            return ApiResource::success([
                'notes' => $notes,
                'count' => $notes->count()
            ], 'Notes récupérées avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des notes utilisateur', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la récupération des notes',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Supprimer une note spécifique.
     *
     * @param  int  $enigmaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($enigmaId)
    {
        try {
            // Vérifier que l'énigme existe
            $enigma = Enigma::findOrFail($enigmaId);

            // Récupérer l'utilisateur authentifié
            $user = Auth::user() ?? request()->user();

            // Supprimer la note
            $deleted = Note::where('user_id', $user->id)
                ->where('enigma_id', $enigmaId)
                ->delete();

            if ($deleted) {
                return ApiResource::success(null, 'Note supprimée avec succès');
            } else {
                return ApiResource::error('Aucune note trouvée pour cette énigme', null, 404);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression d\'une note', [
                'enigma_id' => $enigmaId,
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la suppression de la note',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Créer ou mettre à jour plusieurs notes en une seule requête
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateBatch(Request $request)
    {
        try {
            $request->validate([
                'notes' => 'required|array',
                'notes.*.enigma_id' => 'required|integer|exists:enigmas,id',
                'notes.*.content' => 'nullable|string',
            ]);

            $user = Auth::user() ?? $request->user();
            $results = [];
            $count = 0;

            DB::beginTransaction();

            foreach ($request->notes as $noteData) {
                $note = Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'enigma_id' => $noteData['enigma_id']
                    ],
                    [
                        'content' => $noteData['content'] ?? null
                    ]
                );

                $results[] = [
                    'enigma_id' => $note->enigma_id,
                    'content' => $note->content,
                    'status' => $note->wasRecentlyCreated ? 'created' : 'updated'
                ];

                $count++;
            }

            DB::commit();

            Log::info('Notes sauvegardées en batch', [
                'user_id' => $user->id,
                'count' => $count
            ]);

            return ApiResource::success([
                'results' => $results,
                'count' => $count
            ], "$count notes sauvegardées avec succès");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la sauvegarde batch des notes', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la sauvegarde des notes',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }

    public function getAllNotesForUser(Request $request)
    {
        try {
            $user = Auth::user() ?? $request->user();

            // Récupérer toutes les notes avec les titres des énigmes
            $notes = Note::where('user_id', $user->id)
                ->with('enigma:id,title')
                ->get()
                ->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'enigma_id' => $note->enigma_id,
                        'enigma_title' => $note->enigma->title ?? 'Énigme inconnue',
                        'content' => $note->content,
                        'updated_at' => $note->updated_at,
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Notes récupérées avec succès',
                'data' => $notes,
                'count' => $notes->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur récupération notes utilisateur : ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des notes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
