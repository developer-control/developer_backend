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
            'id' => $this->id,
            'developer' => [
                'id' => $this->developer_id,
                'name' => $this->developer_name,
            ],
            'project' => [
                'id' => $this->project_id,
                'name' => $this->project_name,
            ],
            'project_area' => [
                'id' => $this->project_area_id,
                'name' => $this->area_name,
            ],
            'project_bloc' => [
                'id' => $this->project_bloc_id,
                'name' => $this->bloc_name,
            ],
            'project_unit' => [
                'id' => $this->project_unit_id,
                'name' => $this->unit_name,
            ],
            'city' => [
                'id' => $this->city_id,
                'name' => $this->city_name,
            ],
            'ownership_unit' => [
                'id' => $this->ownership_unit_id,
                'name' => $this->ownership_unit_name,
            ],
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
