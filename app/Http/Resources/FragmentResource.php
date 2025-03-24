<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FragmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fragment' => $this->fragment,
            'fragment_order' => $this->fragment_order,
            'enigma' => [
                'id' => $this->enigma->id,
                'title' => $this->enigma->title,
                'difficulty' => $this->enigma->difficulty
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
