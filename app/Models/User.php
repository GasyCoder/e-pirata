<?php

namespace App\Models;

use App\Models\Enigma;
use App\Models\Chapter;
use App\Models\Achievement;
use App\Models\UserProgress;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserProgressChapter;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'bio',
        'avatar',
        'google_id',
        'google_token',
        'google_refresh_token',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'points' => 'integer'
    ];

    protected $attributes = [
        'points' => 0
    ];

    // Désactiver l'envoi automatique de l'email de vérification par Laravel
    public function sendEmailVerificationNotification()
    {
        // Ne rien faire pour empêcher Laravel d'envoyer l'e-mail automatique
    }

    public function enigmaProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function enigmas(): BelongsToMany
    {
        return $this->belongsToMany(Enigma::class, 'user_progress')
                    ->withPivot(['completed', 'completed_at', 'hints_used', 'attempts'])
                    ->withTimestamps();
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class, 'user_progress_chapters')
                    ->withPivot(['completed', 'completed_at', 'points_earned', 'collected_items'])
                    ->withTimestamps();
    }

    public function chapterProgress(): HasMany
    {
        return $this->hasMany(UserProgressChapter::class);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot(['earned_at'])
                    ->withTimestamps();
    }

    public function getTotalPoints(): int
    {
        return 0;
    }

    public function getCompletionPercentage(): float
    {
        $totalEnigmas = Enigma::count();
        if ($totalEnigmas === 0) return 0;

        $completedEnigmas = $this->enigmas()
                                ->wherePivot('completed', true)
                                ->count();

        return ($completedEnigmas / $totalEnigmas) * 100;
    }

    public static function getLeaderboard($limit = 10)
    {
        return static::orderByDesc('points')->limit($limit)->get();
    }

    public function getRank(): int
    {
        return static::where('points', '>', $this->points)->count() + 1;
    }

    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function fragments()
    {
        return $this->hasMany(UserFragment::class);
    }
}
