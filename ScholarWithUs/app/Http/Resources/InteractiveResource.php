<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractiveResource extends JsonResource
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
            'program_id' => $this->program_id,
            'date' => $this->date,
            'start' => $this->start,
            'finish' => $this->finish,
            'zoom' => $this->zoom,
        ];
    }
}
