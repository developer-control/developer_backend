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
            'vehicle_numbe' => $this->vehicle_numbe,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
