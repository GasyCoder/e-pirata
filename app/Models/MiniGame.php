<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MiniGame extends Model
{
    protected $fillable = [
        'chapter_id',
        'type',
        'title',
        'description',
        'game_data',
        'points_reward',
        'unlock_condition',
    ];

    protected $casts = [
        'game_data' => 'array',
        'unlock_condition' => 'array',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function isUnlocked(User $user): bool
    {
        if (!$this->unlock_condition) {
            return true;
        }

        $condition = $this->unlock_condition;

        // Vérifier les conditions de déblocage
        if (isset($condition['required_points'])) {
            $userPoints = $user->chapters()
                              ->wherePivot('chapter_id', $this->chapter_id)
                              ->first()
                              ->pivot
                              ->points_earned;
            
            if ($userPoints < $condition['required_points']) {
                return false;
            }
        }

        if (isset($condition['required_items'])) {
            $userItems = $user->chapters()
                             ->wherePivot('chapter_id', $this->chapter_id)
                             ->first()
                             ->pivot
                             ->collected_items;
            
            $userItems = json_decode($userItems, true) ?? [];
            
            foreach ($condition['required_items'] as $item) {
                if (!in_array($item, $userItems)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getGameData(): array
    {
        return match($this->type) {
            'memory' => $this->getMemoryGameData(),
            'puzzle' => $this->getPuzzleGameData(),
            'decode' => $this->getDecodeGameData(),
            'navigation' => $this->getNavigationGameData(),
            default => [],
        };
    }

    private function getMemoryGameData(): array
    {
        $gameData = $this->game_data;
        return [
            'cards' => $gameData['cards'] ?? [],
            'time_limit' => $gameData['time_limit'] ?? 120,
            'pairs_count' => $gameData['pairs_count'] ?? 8,
        ];
    }

    private function getPuzzleGameData(): array
    {
        $gameData = $this->game_data;
        return [
            'image' => $gameData['image'] ?? '',
            'grid_size' => $gameData['grid_size'] ?? 3,
            'time_limit' => $gameData['time_limit'] ?? 300,
        ];
    }

    private function getDecodeGameData(): array
    {
        $gameData = $this->game_data;
        return [
            'cipher_text' => $gameData['cipher_text'] ?? '',
            'hints' => $gameData['hints'] ?? [],
            'solution' => $gameData['solution'] ?? '',
        ];
    }

    private function getNavigationGameData(): array
    {
        $gameData = $this->game_data;
        return [
            'map' => $gameData['map'] ?? '',
            'start_position' => $gameData['start_position'] ?? [],
            'end_position' => $gameData['end_position'] ?? [],
            'obstacles' => $gameData['obstacles'] ?? [],
        ];
    }
}
