<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Enigma;
use App\Models\Winner;
use App\Models\UserFragment;
use App\Models\UserProgress;
use App\Services\FragmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Log;

class TreasureApiController extends Controller
{
    /**
     * Le service d'assemblage de fragments.
     *
     * @var \App\Services\FragmentService
     */
    protected $fragmentService;

    /**
     * Constructeur du contrôleur.
     *
     * @param \App\Services\FragmentService $fragmentService
     */
    public function __construct(FragmentService $fragmentService)
    {
        $this->fragmentService = $fragmentService;
    }

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
            return ApiResource::error(
                'Vous devez résoudre toutes les énigmes d\'abord !',
                null,
                403
            );
        }

        // Vérifier si l'utilisateur a déjà validé le trésor
        $existingWinner = Winner::where('user_id', $user->id)
            ->where('treasure_hunt_id', $treasureHuntId)
            ->first();

        if ($existingWinner) {
            return ApiResource::success(
                [
                    'already_won' => true,
                    'rank' => $existingWinner->rank,
                    'completed_at' => $existingWinner->completed_at
                ],
                "Vous avez déjà validé ce trésor et êtes classé {$existingWinner->rank}e !",
                200
            );
        }

        try {
            // Utiliser le service d'assemblage pour valider le code
            $isCorrect = $this->fragmentService->validateCode($user->id, $request->code, '-');

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

                // Journaliser la validation du trésor
                Log::info('Trésor validé', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'rank' => $rank,
                    'treasure_hunt_id' => $treasureHuntId
                ]);

                return ApiResource::success(
                    [
                        'rank' => $rank,
                        'is_first_winner' => $isFirstWinner,
                        'completed_at' => $winner->completed_at,
                        'treasure_hunt_id' => $treasureHuntId
                    ],
                    $message,
                    200
                );
            }

            // Journaliser la tentative échouée
            Log::info('Tentative de validation de trésor échouée', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'code_submitted' => $request->code
            ]);

            return ApiResource::error(
                'Ce n\'est pas le bon code. Vérifiez l\'ordre de vos fragments.',
                null,
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();

            // Journaliser l'erreur
            Log::error('Erreur lors de la validation du trésor', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResource::error(
                'Une erreur est survenue lors de la validation du trésor.',
                ['exception' => $e->getMessage()],
                500
            );
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

        return ApiResource::success([
            'winners' => $winners,
            'top_users' => $topUsers,
            'user_rank' => [
                'rank' => $userRank,
                'name' => $user->name,
                'points' => $user->points
            ]
        ], 'Classement récupéré avec succès');
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

        return ApiResource::success([
            'recent_winners' => $recentWinners
        ], 'Gagnants récents récupérés avec succès');
    }

    /**
     * Récupérer des statistiques sur les fragments et la progression
     */
    public function getFragmentsStats(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        // Utiliser le service pour récupérer les statistiques
        $fragmentStats = $this->fragmentService->getFragmentsProgress($user->id);

        return ApiResource::success($fragmentStats, 'Statistiques des fragments récupérées avec succès');
    }

    /**
     * Récupérer le code assemblé pour un utilisateur (admin uniquement)
     */
    public function getAssembledCode(Request $request, $userId)
    {
        // Vérifier si l'utilisateur est admin
        $currentUser = Auth::user() ?? $request->user();
        if ($currentUser->email !== 'admin@pirata.fr') {
            return ApiResource::error(
                'Non autorisé. Cette action est réservée aux administrateurs.',
                null,
                403
            );
        }

        // Vérifier que l'utilisateur cible existe
        $targetUser = User::find($userId);
        if (!$targetUser) {
            return ApiResource::error(
                'Utilisateur non trouvé',
                null,
                404
            );
        }

        // Utiliser le service pour récupérer le code assemblé
        $code = $this->fragmentService->assembleFragments($userId, '-');
        $hasAllFragments = $this->fragmentService->hasAllFragments($userId);

        return ApiResource::success([
            'user_id' => (int)$userId,
            'user_name' => $targetUser->name,
            'code' => $code,
            'has_all_fragments' => $hasAllFragments,
            'fragments_count' => UserFragment::where('user_id', $userId)->count(),
            'total_enigmas' => Enigma::count()
        ], 'Code assemblé récupéré avec succès');
    }
}
