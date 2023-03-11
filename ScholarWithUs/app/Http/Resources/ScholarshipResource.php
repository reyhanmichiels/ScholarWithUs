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
            'description' => $this->description,
            'university' => $this->university,
            'study_program' => $this->study_program,
            'benefit' => $this->benefit,
            'age' => $this->age,
            'gpa' => $this->gpa,
            'english_test' => $this->english_test,
            'other_language_test' => $this->other_language_test,
            'standarized_test' => $this->standarized_test,
            'documents' => $this->documents,
            'other' => $this->other,
            'detail_information' => $this->scholarship_provider,
            'open_registration' => $this->open_registration,
            'close_registration' => $this->close_registration,
            'tag_level' => $this->tagLevels,
            'tag_cost' => $this->tagCosts,
            'tag_countries' => $this->tagCountries,
        ];
    }
}
