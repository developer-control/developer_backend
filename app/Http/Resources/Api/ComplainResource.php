<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = @json_decode(@$this->images, true) ?? [];
        $images = [];
        foreach (@$media as $item) {
            array_push($images, storage_url($item));
        }
        return [
            'id' => (int) $this->id,
            'developer' => @$this->developer ? [
                'id' => (int)$this->developer_id,
                'name' => @$this->developer->name,
            ] : null,
            'project' => @$this->project ? [
                'id' => (int)$this->project_id,
                'name' => @$this->project->name,
            ] : null,
            'project_area' => @$this->projectArea ? [
                'id' => (int) $this->project_area_id,
                'name' => @$this->projectArea->name,
            ] : null,

            'project_unit' => @$this->projectUnit ? [
                'id' => (int) $this->project_unit_id,
                'name' => @$this->projectUnit->name,
            ] : null,
            'title' => $this->title,
            'images' => $images,
            'address' => $this->address,
            'description' => $this->description,
            'solved_notes' => $this->solved_notes,
            'type' => $this->type,
            'status' => $this->status,
            'solved_by' => @$this->solvedBy ? [
                'id' => (int) $this->solved_by,
                'name' => @$this->solvedBy->name,
            ] : null,
            'solved_at' => $this->solved_at ? $this->solved_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
