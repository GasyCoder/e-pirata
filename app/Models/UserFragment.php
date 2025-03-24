<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Enigma;

class UserFragment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enigma_id',
        'fragment',
        'fragment_order'
    ];

    protected $casts = [
        'fragment_order' => 'integer'
    ];

    /**
     * L'utilisateur propriétaire de ce fragment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * L'énigme liée à ce fragment
     */
    public function enigma()
    {
        return $this->belongsTo(Enigma::class);
    }

    /**
     * Récupérer tous les fragments d'un utilisateur dans l'ordre
     */
    public static function getUserFragmentsOrdered($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('fragment_order')
            ->get();
    }

    /**
     * Construire le code complet à partir des fragments de l'utilisateur
     */
    public static function getUserTreasureCode($userId)
    {
        $fragments = self::getUserFragmentsOrdered($userId)
            ->pluck('fragment');

        return $fragments->implode('-');
    }
}
