<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'developer' => @$this->developer ? [
                'id' => (int)$this->developer_id,
                'name' => @$this->developer->name,
            ] : null,
            'project_unit' => @$this->projectUnit ? [
                'id' => (int) $this->project_unit_id,
                'name' => @$this->projectUnit->name,
            ] : null,
            'name' => $this->name,
            'vehicle_number' => $this->vehicle_number,
            'start_date' => $this->start_date->format('Y-m-d'),
            'start_time' => $this->start_time->format('H:i:s'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'end_time' => $this->end_time->format('H:i:s'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
