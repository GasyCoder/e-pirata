<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Enigma;
use App\Models\Winner;
use App\Models\UserFragment;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TreasureApiController extends Controller
{
    /**
     * Valider le code du trésor
     */
    public function validateTreasureCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user() ?? $request->user();
        $treasureHuntId = 1; // ID de la chasse en cours

        // Vérifier que l'utilisateur a résolu toutes les énigmes
        if (!$this->hasCompletedAllEnigmas($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez résoudre toutes les énigmes d\'abord !'
            ], 403);
        }

        // Vérifier si l'utilisateur a déjà validé le trésor
        $existingWinner = Winner::where('user_id', $user->id)
            ->where('treasure_hunt_id', $treasureHuntId)
            ->first();

        if ($existingWinner) {
            return response()->json([
                'success' => true,
                'already_won' => true,
                'rank' => $existingWinner->rank,
                'message' => "Vous avez déjà validé ce trésor et êtes classé {$existingWinner->rank}e !"
            ]);
        }

        try {
            // Récupérer les fragments de l'utilisateur dans l'ordre
            $userFragments = UserFragment::where('user_id', $user->id)
                ->orderBy('fragment_order')
                ->pluck('fragment');

            // Construire le code attendu
            $expectedCode = $userFragments->implode('-');

            // Vérifier si le code soumis correspond (insensible à la casse)
            $isCorrect = strtolower(trim($request->code)) === strtolower(trim($expectedCode));

            if ($isCorrect) {
                DB::beginTransaction();

                // Déterminer le rang du joueur
                $rank = Winner::where('treasure_hunt_id', $treasureHuntId)->count() + 1;

                // Enregistrer le joueur comme gagnant
                $winner = Winner::create([
                    'user_id' => $user->id,
                    'treasure_hunt_id' => $treasureHuntId,
                    'completed_at' => now(),
                    'rank' => $rank
                ]);

                DB::commit();

                $isFirstWinner = $rank === 1;

                // Message personnalisé selon le rang
                if ($isFirstWinner) {
                    $message = 'Félicitations ! Vous êtes le premier à avoir trouvé le trésor !';
                } else {
                    $message = "Félicitations ! Vous avez trouvé le trésor et êtes classé {$rank}e !";
                }

                return response()->json([
                    'success' => true,
                    'rank' => $rank,
                    'is_first_winner' => $isFirstWinner,
                    'completed_at' => $winner->completed_at,
                    'message' => $message
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Ce n\'est pas le bon code. Vérifiez l\'ordre de vos fragments.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la validation du trésor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier si l'utilisateur a résolu toutes les énigmes
     */
    private function hasCompletedAllEnigmas($userId)
    {
        $totalEnigmas = Enigma::count();

        if ($totalEnigmas === 0) {
            return false;
        }

        $completedEnigmas = UserProgress::where('user_id', $userId)
            ->where('completed', true)
            ->count();

        return $totalEnigmas === $completedEnigmas;
    }


    /**
     * Récupérer le classement des gagnants
     */
    public function getLeaderboard(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        // Récupérer les gagnants
        $winners = Winner::with(['user:id,name,avatar,points'])
            ->orderBy('rank')
            ->take(10)
            ->get()
            ->map(function($winner) {
                return [
                    'rank' => $winner->rank,
                    'name' => $winner->user->name,
                    'avatar' => $winner->user->avatar,
                    'points' => $winner->user->points,
                    'completed_at' => $winner->completed_at->format('d/m/Y H:i')
                ];
            });

        // Récupérer aussi le classement général par points (top 10)
        $topUsers = User::orderBy('points', 'desc')
            ->take(10)
            ->get(['id', 'name', 'avatar', 'points'])
            ->map(function($user, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'points' => $user->points
                ];
            });

        // Récupérer la position de l'utilisateur actuel dans le classement par points
        $userRank = User::where('points', '>', $user->points)->count() + 1;

        return response()->json([
            'winners' => $winners,
            'top_users' => $topUsers,
            'user_rank' => [
                'rank' => $userRank,
                'name' => $user->name,
                'points' => $user->points
            ]
        ]);
    }


    /**
     * Récupérer les derniers gagnants
     */
    public function getRecentWinners(Request $request)
    {
        $limit = $request->input('limit', 5);

        $recentWinners = Winner::with(['user:id,name,avatar,points'])
            ->orderBy('completed_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($winner) {
                return [
                    'rank' => $winner->rank,
                    'name' => $winner->user->name,
                    'avatar' => $winner->user->avatar,
                    'completed_at' => $winner->completed_at->format('d/m/Y H:i'),
                    'time_ago' => $winner->completed_at->diffForHumans()
                ];
            });

        return response()->json([
            'recent_winners' => $recentWinners
        ]);
    }

}
