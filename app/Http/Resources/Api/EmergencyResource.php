<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyResource extends JsonResource
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
            'title' => $this->title,
            'number' => $this->number,
        ];
    }
}
