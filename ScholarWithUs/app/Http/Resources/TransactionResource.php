<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'program_id' => $this->program_id,
            'gross_amount' => $this->gross_amount,
            'bank' => $this->bank,
            'status' => $this->status,
            'user' => $this->users,
            'programs' => $this->programs
        ];
    }
}
