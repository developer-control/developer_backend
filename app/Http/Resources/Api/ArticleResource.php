<?php

namespace App\Http\Resources\Api;

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
            'id' => (int)$this->id,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'image' => storage_url($this->image),
            'title' => $this->title,
            'short_content' => $this->short_content,
            'content' => $this->content,
            'created_by' => [
                'id' => (int)@$this->created_by,
                'name' => @$this->createdBy->name
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
