<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipResource extends JsonResource
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
            'tag_level_id' => $this->tag_level_id,
            'tag_cost_id' => $this->tag_cost_id,
            'name' => $this->name,
            'scholarship_provider' => $this->scholarship_provider,
            'open_registration' => $this->open_registration,
            'close_registration' => $this->close_registration,
            'tag_level' => $this->tagLevels,
            'tag_cost' => $this->tagCosts,
            'tag_countries' => $this->tagCountries,
        ];
    }
}
