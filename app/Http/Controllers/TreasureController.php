<?php

namespace App\Http\Controllers;

use App\Models\Enigma;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasureController extends Controller
{
    public function showValidationForm()
    {
        $user = Auth::user();
        $completedEnigmas = Enigma::whereHas('userProgress', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('completed', true);
        })->orderBy('id')->get();

        $fragments = $completedEnigmas->pluck('fragment')->toArray();

        return view('treasure.validate', [
            'fragments' => $fragments
        ]);
    }

    public function checkTreasureCode(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur a résolu toutes les énigmes
        $enigmasCount = Enigma::count();
        $completedCount = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        if ($completedCount < $enigmasCount) {
            return back()->with('error', 'Vous devez résoudre toutes les énigmes avant de pouvoir valider le trésor !');
        }

        // Récupérer les fragments dans l'ordre
        $fragments = Enigma::whereHas('userProgress', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('completed', true);
        })->orderBy('id')->pluck('fragment')->toArray();

        // Assembler le code correct
        $correctCode = implode('', $fragments);

        // Vérifier le code soumis
        if ($request->code === $correctCode) {
            // Marquer l'utilisateur comme gagnant
            UserProgress::where('user_id', $user->id)
                ->update([
                    'is_winner' => true,
                    'winner_at' => now()
                ]);

            return back()->with('success', 'Félicitations ! Vous avez découvert le trésor d\'El Pirata !');
        }

        return back()->with('error', 'Le code n\'est pas correct. Vérifiez l\'ordre des fragments et réessayez !');
    }
}
