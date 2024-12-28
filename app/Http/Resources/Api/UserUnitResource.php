<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserUnitResource extends JsonResource
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
            'developer' => [
                'id' => (int) $this->developer_id,
                'name' => $this->developer_name,
            ],
            'project' => [
                'id' => (int)$this->project_id,
                'name' => $this->project_name,
            ],
            'project_area' => [
                'id' => (int)$this->project_area_id,
                'name' => $this->area_name,
            ],
            'project_bloc' => [
                'id' => (int)$this->project_bloc_id,
                'name' => $this->bloc_name,
            ],
            'project_unit' => [
                'id' => (int) $this->project_unit_id,
                'name' => $this->unit_name,
            ],
            'city' => [
                'id' => (int) $this->city_id,
                'name' => $this->city_name,
            ],
            'ownership_unit' => [
                'id' => (int) $this->ownership_unit_id,
                'name' => $this->ownership_unit_name,
            ],
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
