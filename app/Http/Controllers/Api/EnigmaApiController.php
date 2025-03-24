<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Enigma;
use App\Models\UserFragment;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EnigmaApiController extends Controller
{
    /**
     * Valider la réponse à une énigme
     */
    public function validateAnswer(Request $request, $enigmaId)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $enigma = Enigma::findOrFail($enigmaId);
        $user = Auth::user() ?? $request->user();

        // Vérifier si la réponse est correcte
        $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($enigma->answer));

        // Enregistrer la tentative et le temps
        $userProgress = UserProgress::firstOrNew([
            'user_id' => $user->id,
            'enigma_id' => $enigmaId,
        ]);

        // Si c'est la première visualisation, enregistrer l'heure
        if (!$userProgress->first_viewed_at) {
            $userProgress->first_viewed_at = now();
        }

        $userProgress->attempts = ($userProgress->attempts ?? 0) + 1;
        $userProgress->user_answer = $request->answer;

        // Initialiser la variable de fragment
        $fragment = null;

        if ($isCorrect && !$userProgress->completed) {
            $userProgress->completed = true;
            $userProgress->completed_at = now();

            // Calculer le temps passé
            $timeSpent = now()->diffInSeconds($userProgress->first_viewed_at);
            $userProgress->time_spent = $timeSpent;

            // Générer un fragment unique pour cet utilisateur et cette énigme
            $fragment = $this->generateUniqueFragment($user->id, $enigmaId);

            // Mettre à jour les points de l'utilisateur
            $user->points += $enigma->points;
            $user->save();

            $message = "Félicitations ! Vous avez résolu l'énigme" .
                      ($userProgress->attempts == 1 ? " du premier coup !" : " en {$userProgress->attempts} tentatives !") .
                      "\nVous avez obtenu le fragment : {$fragment}";
        } else {
            $message = "Ce n'est pas la bonne réponse. Essayez encore !";
        }

        $userProgress->save();

        return response()->json([
            'success' => $isCorrect,
            'completed' => $isCorrect && !$userProgress->completed ? true : $userProgress->completed ?? false,
            'data' => [
                'attempts' => $userProgress->attempts,
                'points_earned' => $isCorrect && !$userProgress->completed ? $enigma->points : 0,
                'fragment' => $fragment,
                'time_spent' => $userProgress->time_spent ?? null
            ],
            'message' => $message,
            'errors' => null
        ]);
    }


    /**
     * Générer un fragment unique pour un utilisateur et une énigme
     */
    private function generateUniqueFragment($userId, $enigmaId)
    {
        // Créer un hash basé sur l'ID utilisateur et l'ID énigme
        $seed = $userId . '_' . $enigmaId . '_' . config('app.key');
        $hash = hash('sha256', $seed);

        // Utiliser ce hash pour générer un fragment de type "BZ4", "##9A", etc.
        $charPool1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charPool2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#@$%&';

        $fragment = '';
        $fragment .= $charPool1[hexdec(substr($hash, 0, 2)) % strlen($charPool1)];
        $fragment .= $charPool1[hexdec(substr($hash, 2, 2)) % strlen($charPool1)];
        $fragment .= $charPool2[hexdec(substr($hash, 4, 2)) % strlen($charPool2)];

        // Stocker le fragment dans la base de données
        UserFragment::updateOrCreate(
            ['user_id' => $userId, 'enigma_id' => $enigmaId],
            ['fragment' => $fragment, 'fragment_order' => $enigmaId]
        );

        return $fragment;
    }


    /**
     * Récupérer tous les fragments d'un utilisateur
     */
    public function getUserFragments(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        $fragments = UserFragment::where('user_id', $user->id)
            ->orderBy('fragment_order')
            ->with('enigma:id,title,difficulty') // Eager load enigma with selected fields
            ->get();

        $totalEnigmas = Enigma::count();
        $completedEnigmas = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        $percentage = $totalEnigmas > 0 ? round(($completedEnigmas / $totalEnigmas) * 100) : 0;

        return response()->json([
            'fragments' => $fragments,
            'all_completed' => $totalEnigmas === $completedEnigmas,
            'progress' => [
                'total' => $totalEnigmas,
                'completed' => $completedEnigmas,
                'percentage' => $percentage
            ]
        ]);
    }

    /**
     * Obtenir un indice pour une énigme
     */
    public function getHint(Request $request, $enigmaId, $hintNumber)
    {
        // Valider que le numéro d'indice est valide (1, 2 ou 3)
        if (!in_array($hintNumber, [1, 2, 3])) {
            return response()->json([
                'success' => false,
                'message' => 'Numéro d\'indice invalide'
            ], 400);
        }

        $enigma = Enigma::findOrFail($enigmaId);
        $user = Auth::user() ?? $request->user();

        $userProgress = UserProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'enigma_id' => $enigmaId
            ],
            [
                'first_viewed_at' => now(),
                'attempts' => 0,
                'hints_used' => 0
            ]
        );

        // Vérifier que l'utilisateur peut accéder à cet indice
        if ($hintNumber > 1 && ($userProgress->hints_used ?? 0) < ($hintNumber - 1)) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez d\'abord utiliser les indices précédents'
            ], 403);
        }

        // Mettre à jour le nombre d'indices utilisés
        if (($userProgress->hints_used ?? 0) < $hintNumber) {
            $userProgress->hints_used = $hintNumber;
            $userProgress->save();
        }

        // Récupérer l'indice demandé
        $hintField = "hint{$hintNumber}";
        $hint = $enigma->$hintField;

        if (!$hint) {
            return response()->json([
                'success' => false,
                'message' => 'Cet indice n\'est pas disponible'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'hint' => $hint,
            'hint_number' => $hintNumber
        ]);
    }

    /**
     * Récupérer la progression de l'utilisateur
     */
    public function getUserProgress(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        // Récupérer les énigmes complétées
        $completedEnigmas = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->with('enigma:id,title,difficulty,points,chapter_id')
            ->get();

        // Récupérer toutes les énigmes
        $allEnigmas = Enigma::select('id', 'title', 'difficulty', 'points', 'chapter_id')
            ->orderBy('chapter_id')
            ->orderBy('order')
            ->get();

        // Calculer le pourcentage global de progression
        $totalEnigmas = $allEnigmas->count();
        $completedCount = $completedEnigmas->count();
        $percentage = $totalEnigmas > 0 ? round(($completedCount / $totalEnigmas) * 100) : 0;

        // Ajouter le statut complété à chaque énigme
        $enigmasWithStatus = $allEnigmas->map(function($enigma) use ($completedEnigmas) {
            $completed = $completedEnigmas->contains('enigma_id', $enigma->id);
            return [
                'id' => $enigma->id,
                'title' => $enigma->title,
                'difficulty' => $enigma->difficulty,
                'points' => $enigma->points,
                'chapter_id' => $enigma->chapter_id,
                'completed' => $completed
            ];
        });

        return response()->json([
            'enigmas' => $enigmasWithStatus,
            'progress' => [
                'total' => $totalEnigmas,
                'completed' => $completedCount,
                'percentage' => $percentage,
                'points' => $user->points
            ],
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'points' => $user->points,
                'rank' => $this->getUserRank($user->id)
            ]
        ]);
    }

    /**
     * Vérifier si l'utilisateur a complété toutes les énigmes
     */
    public function hasCompletedAllEnigmas(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        $totalEnigmas = Enigma::count();
        $completedEnigmas = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        $allCompleted = $totalEnigmas === $completedEnigmas;

        return response()->json([
            'all_completed' => $allCompleted,
            'total' => $totalEnigmas,
            'completed' => $completedEnigmas,
            'percentage' => $totalEnigmas > 0 ? round(($completedEnigmas / $totalEnigmas) * 100) : 0
        ]);
    }

    /**
     * Obtenir le rang d'un utilisateur
     */
    private function getUserRank($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }

        // Compter combien d'utilisateurs ont plus de points
        $higherRanked = User::where('points', '>', $user->points)->count();

        // Rang = position + 1 (car on commence à 0)
        return $higherRanked + 1;
    }
}
