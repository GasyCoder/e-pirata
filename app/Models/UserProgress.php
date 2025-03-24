<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Enigma;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enigma_id',
        'attempts',
        'hints_used',
        'user_answer',
        'completed',
        'completed_at',
        'is_winner',
        'winner_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'is_winner' => 'boolean',
        'completed_at' => 'datetime',
        'winner_at' => 'datetime',
        'attempts' => 'integer',
        'hints_used' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enigma()
    {
        return $this->belongsTo(Enigma::class);
    }
}
