<?php

namespace App\Http\Resources;

use App\Models\Enigma;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'points' => $this->points,
            'rank' => $this->getRank(),
            'completed_enigmas' => $this->enigmas()->wherePivot('completed', true)->count(),
            'total_enigmas' => Enigma::count(),
        ];
    }
}
