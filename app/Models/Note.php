<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'enigma_id',
        'content'
    ];

    /**
     * Les règles de conversion d'attributs.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
    ];

    /**
     * Relation avec l'utilisateur propriétaire de la note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'énigme associée à la note.
     */
    public function enigma()
    {
        return $this->belongsTo(Enigma::class);
    }
}
