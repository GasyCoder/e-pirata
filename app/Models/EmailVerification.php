<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Vérifier si le code est expiré
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    // Générer un nouveau code de vérification
    public static function generateCode()
    {
        return str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }
}
