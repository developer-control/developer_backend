<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
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
            'developer' => new DeveloperResource($this->developer),
            'project' => new ProjectResource($this->project),
            'image' => storage_url($this->image),
            'title' => $this->title,
            'description' => $this->description,
            'created_by' => [
                'id' => (int)@$this->created_by,
                'name' => @$this->createdBy->name
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
