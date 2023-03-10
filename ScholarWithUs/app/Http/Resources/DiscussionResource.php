<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
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
            'title' => $this->title,
            'comment' => $this->comment,
            'reply_count' => $this->replies()->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->users,
            'tag_discussion' => $this->tagDiscussions
        ];
    }
}
