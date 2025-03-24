<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'points',
        'condition_type',
        'condition_value'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withTimestamps()
            ->withPivot('earned_at');
    }

    public static function checkAndAward($user, $type, $value)
    {
        $achievements = self::where('condition_type', $type)
            ->where('condition_value', '<=', $value)
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        foreach ($achievements as $achievement) {
            $user->achievements()->attach($achievement->id, [
                'earned_at' => now()
            ]);
            $user->increment('points', $achievement->points);
        }

        return $achievements;
    }
}
