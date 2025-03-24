<?php

namespace App\Http\Controllers;

use App\Models\Enigma;
use App\Models\UserProgress;
use App\Models\Achievement;
use App\Models\Chapter;
use App\Models\UserFragment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EnigmaController extends Controller
{
    public function index(Request $request)
    {
        $query = Enigma::query();

        // Filtrage
        if ($request->filter === 'non-resolues') {
            $query->whereDoesntHave('userProgress', function($q) {
                $q->where('user_id', Auth::id())
                  ->where('completed', true);
            });
        } elseif ($request->filter === 'completees') {
            $query->whereHas('userProgress', function($q) {
                $q->where('user_id', Auth::id())
                  ->where('completed', true);
            });
        }

        // Filtrage par chapitre
        if ($request->chapter) {
            $query->where('chapter_id', $request->chapter);
        }

        // Recherche
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Pagination avec conservation des paramètres de requête
        $enigmas = $query->orderBy('chapter_id')->orderBy('order')->paginate(6);
        $enigmas->appends($request->all());

        // Récupérer les chapitres pour le filtre
        $chapters = Chapter::orderBy('order')->get();

        return view('enigmas.index', compact('enigmas', 'chapters'));
    }

    public function show(Enigma $enigma)
    {
        // Utilisation de firstOrCreate pour s'assurer d'avoir un enregistrement
        $userProgress = UserProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'enigma_id' => $enigma->id
            ],
            [
                'first_viewed_at' => now(),
                'attempts' => 0,
                'hints_used' => 0,
                'completed' => false
            ]
        );

        // Vérifier les prérequis
        $canAttempt = true;
        $requiredEnigmas = [];

        if ($enigma->required_enigmas) {
            $requiredEnigmas = Enigma::whereIn('id', $enigma->required_enigmas)->get();
            foreach ($requiredEnigmas as $required) {
                if (!$required->isCompletedByUser(Auth::id())) {
                    $canAttempt = false;
                    break;
                }
            }
        }

        return view('enigmas.show', compact('enigma', 'userProgress', 'canAttempt', 'requiredEnigmas'));
    }

    public function verify(Request $request, Enigma $enigma)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $userProgress = UserProgress::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'enigma_id' => $enigma->id
                ],
                [
                    'first_viewed_at' => now(),
                    'attempts' => 0,
                    'hints_used' => 0,
                    'completed' => false
                ]
            );

            // Mettre à jour les statistiques
            $userProgress->attempts = ($userProgress->attempts ?? 0) + 1;
            $userProgress->user_answer = $request->answer;

            // Calculer le temps passé
            if ($userProgress->first_viewed_at) {
                $timeSpent = Carbon::now()->diffInSeconds($userProgress->first_viewed_at);
                $userProgress->time_spent = $timeSpent;
            }

            // Sauvegarder l'historique des tentatives
            $attemptHistory = $userProgress->attempt_history ?? [];
            $attemptHistory[] = [
                'answer' => $request->answer,
                'timestamp' => now()->toDateTimeString(),
                'time_spent' => $userProgress->time_spent ?? 0
            ];
            $userProgress->attempt_history = $attemptHistory;

            $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($enigma->answer));

            $points = 0;

            if ($isCorrect && !$userProgress->completed) {
                $userProgress->completed = true;
                $userProgress->completed_at = now();

                // Calcul des points en fonction de plusieurs facteurs
                $points = $this->calculatePoints($userProgress, $enigma);

                $user = Auth::user();
                $user->points = ($user->points ?? 0) + $points;
                $user->save();

                // Générer un fragment unique
                $fragment = $this->generateUniqueFragment($user->id, $enigma->id);

                // Vérifier la progression du chapitre
                if ($enigma->chapter_id) {
                    $this->checkChapterProgress($enigma->chapter_id);
                }

                // Vérifier les succès débloqués
                $this->checkAchievements($user, $enigma);

                $message = "Félicitations ! Vous avez résolu l'énigme" .
                          ($userProgress->attempts == 1 ? " du premier coup !" : " en $userProgress->attempts tentatives !") .
                          "\nVous gagnez $points points !" .
                          "\nVous avez obtenu le fragment : {$fragment}";
            } else {
                $message = $this->getFailureMessage($userProgress->attempts);
                $fragment = null;
            }

            $userProgress->save();

            DB::commit();

            return response()->json([
                'success' => $isCorrect,
                'message' => $message,
                'points' => $isCorrect ? $points : 0,
                'fragment' => $fragment,
                'attempts' => $userProgress->attempts
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
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

    private function calculatePoints(UserProgress $progress, Enigma $enigma)
    {
        // Points de base selon la difficulté
        $basePoints = $enigma->points;

        // Multiplicateur selon le nombre de tentatives
        $attemptMultiplier = match(true) {
            $progress->attempts == 1 => 1.0,    // 100% des points pour la première tentative
            $progress->attempts == 2 => 0.75,   // 75% pour la deuxième
            $progress->attempts == 3 => 0.5,    // 50% pour la troisième
            default => 0.25                     // 25% pour les tentatives suivantes
        };

        // Bonus pour rapidité (si résolu en moins de 5 minutes)
        $timeBonus = 0;
        if (($progress->time_spent ?? 0) < 300) { // 5 minutes
            $timeBonus = $basePoints * 0.2; // 20% bonus
        }

        // Bonus pour énigme bonus
        if ($enigma->is_bonus ?? false) {
            $basePoints *= 1.5;
        }

        // Pénalité pour utilisation d'indices
        $hintPenalty = ($progress->hints_used ?? 0) * 0.1; // 10% de pénalité par indice
        $hintMultiplier = max(0, 1 - $hintPenalty);

        // Calcul final
        return round(($basePoints * $attemptMultiplier * $hintMultiplier) + $timeBonus);
    }

    private function getFailureMessage($attempts)
    {
        return match(true) {
            $attempts == 1 => "Première tentative échouée... Réessayez !",
            $attempts == 2 => "Pas encore... Concentrez-vous et réessayez !",
            $attempts == 3 => "Troisième tentative... Regardez bien tous les indices !",
            $attempts == 4 => "N'abandonnez pas ! Peut-être devriez-vous utiliser un indice ?",
            default => "Persévérez, chaque erreur vous rapproche de la solution !"
        };
    }

    private function checkChapterProgress($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        $user = Auth::user();

        if (!$chapter) {
            return;
        }

        // Vérifier si toutes les énigmes du chapitre sont complétées
        $allEnigmasCompleted = true;
        $chapterEnigmas = $chapter->enigmas;

        if ($chapterEnigmas->isEmpty()) {
            return;
        }

        foreach ($chapterEnigmas as $enigma) {
            if (!$enigma->isCompletedByUser($user->id)) {
                $allEnigmasCompleted = false;
                break;
            }
        }

        if ($allEnigmasCompleted) {
            $userProgress = $chapter->userProgress()
                ->firstOrCreate(['user_id' => $user->id]);

            if (!$userProgress->completed) {
                $userProgress->completed = true;
                $userProgress->completed_at = now();
                $userProgress->save();

                // Bonus de points pour complétion du chapitre
                $chapterBonus = $chapter->points_earned ?? 100; // Points bonus pour avoir complété le chapitre
                $user->points += $chapterBonus;
                $user->save();
            }
        }
    }

    private function checkAchievements($user, $enigma)
    {
        // Vérifier les succès liés aux énigmes
        $achievements = Achievement::where(function($query) {
                $query->where('condition_type', 'enigma_completion')
                      ->orWhere('condition_type', 'completion')
                      ->orWhere('condition_type', 'no_hints')
                      ->orWhere('condition_type', 'time');
            })
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        foreach ($achievements as $achievement) {
            $shouldUnlock = false;

            // Récupérer la progression de l'utilisateur
            $userProgress = UserProgress::where('user_id', $user->id)
                ->where('enigma_id', $enigma->id)
                ->first();

            if (!$userProgress) {
                continue;
            }

            switch ($achievement->condition_type) {
                case 'completion':
                    // Vérifier le nombre d'énigmes complétées
                    $completedCount = UserProgress::where('user_id', $user->id)
                        ->where('completed', true)
                        ->count();
                    $shouldUnlock = $completedCount >= $achievement->condition_value;
                    break;

                case 'no_hints':
                    // Vérifier si l'énigme a été résolue sans indices
                    $shouldUnlock = $userProgress->hints_used == 0;
                    break;

                case 'time':
                    // Vérifier si l'énigme a été résolue en moins de X secondes
                    $shouldUnlock = $userProgress->time_spent < $achievement->condition_value;
                    break;

                default:
                    $shouldUnlock = false;
            }

            if ($shouldUnlock) {
                $user->achievements()->attach($achievement->id, [
                    'earned_at' => now()
                ]);

                // Ajouter les points du succès
                $user->points += $achievement->points ?? 0;
                $user->save();
            }
        }
    }

    public function hint(Request $request, Enigma $enigma)
    {
        $hintNumber = $request->input('hint_number', 1);

        // Valider que le numéro d'indice est valide (1, 2 ou 3)
        if (!in_array($hintNumber, [1, 2, 3])) {
            return response()->json([
                'success' => false,
                'message' => 'Numéro d\'indice invalide'
            ], 400);
        }

        $userProgress = UserProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'enigma_id' => $enigma->id
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
}
