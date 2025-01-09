<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'city' => [
                'id' => (int) $this->city_id,
                'name' => @$this->city->name
            ],
            'developer' => new DeveloperResource($this->developer),
            'name' => $this->name,
        ];
    }
}
