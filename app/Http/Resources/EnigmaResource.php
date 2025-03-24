<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnigmaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'difficulty' => $this->difficulty,
            'points' => $this->points,
            'chapter_id' => $this->chapter_id,
            'order' => $this->order,
            'completed' => $this->whenPivotLoaded('user_progress', function () {
                return (bool) $this->pivot->completed;
            }),
            'hints_used' => $this->whenPivotLoaded('user_progress', function () {
                return $this->pivot->hints_used;
            }),
            'image_path' => $this->when($this->image_path, $this->image_path),
        ];
    }
}
