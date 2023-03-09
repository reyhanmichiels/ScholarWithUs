<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'scholarship_id' => $this->scholarship_id,
            'tag_level_id' => $this->tag_level_id,
            'tag_cost_id' => $this->tag_cost_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'participant' => $this->users->count() . "/20",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tag_level' => $this->tagLevels,
            'tag_cost' => $this->tagCosts,
            'tag_countries' => $this->tagCountries,
            'mentor' => $this->mentors
        ];
    }
}
