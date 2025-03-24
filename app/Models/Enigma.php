<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserProgress;
use App\Models\Chapter;

class Enigma extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'answer',
        'hint1',
        'hint2',
        'hint3',
        'fragment',
        'points',
        'difficulty',
        'image_path',
        'order',
        'chapter_id'
    ];

    protected $casts = [
        'points' => 'integer',
        'difficulty' => 'integer',
        'order' => 'integer'
    ];

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function isCompletedByUser($userId)
    {
        return $this->userProgress()
            ->where('user_id', $userId)
            ->where('completed', true)
            ->exists();
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function userFragments()
    {
        return $this->hasMany(UserFragment::class);
    }
}
