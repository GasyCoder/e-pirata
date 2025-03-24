<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgressChapter extends Model
{
    use HasFactory;

    protected $table = 'user_progress_chapters';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'completed',
        'completed_at',
        'points_earned'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
