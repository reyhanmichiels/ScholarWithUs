<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'tag_article_id' => $this->tag_article_id,
            'title' => $this->title,
            'brief_description' => $this->brief_description,
            'image' => $this->image,
            'description' => $this->description,
            'tag_article' => $this->tagArticles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
