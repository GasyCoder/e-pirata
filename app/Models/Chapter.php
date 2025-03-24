<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chapter extends Model
{
    protected $fillable = [
        'title',
        'description',
        'story_content',
        'order',
        'location',
        'weather_condition',
        'required_items',
    ];

    protected $casts = [
        'required_items' => 'array',
    ];

    public function miniGames(): HasMany
    {
        return $this->hasMany(MiniGame::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgressChapter::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_progress_chapters')
            ->withPivot('completed', 'completed_at', 'points_earned')
            ->withTimestamps();
    }

    public function enigmas(): HasMany
    {
        return $this->hasMany(Enigma::class);
    }

    public function isCompletedByUser($userId): bool
    {
        return $this->users()
                    ->wherePivot('user_id', $userId)
                    ->wherePivot('completed', true)
                    ->exists();
    }

    public function getPointsEarnedByUser($userId): int
    {
        $progress = $this->users()
                        ->wherePivot('user_id', $userId)
                        ->first();
        
        return $progress ? $progress->pivot->points_earned : 0;
    }

    public function getCollectedItemsByUser($userId): array
    {
        $progress = $this->users()
                        ->wherePivot('user_id', $userId)
                        ->first();
        
        return $progress && $progress->pivot->collected_items 
            ? json_decode($progress->pivot->collected_items, true) 
            : [];
    }
}
