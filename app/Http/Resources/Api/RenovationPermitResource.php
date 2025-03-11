<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RenovationPermitResource extends JsonResource
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
            'title' => $this->title,
            'id_card_photo' => $this->id_card_photo ? storage_url($this->id_card_photo) : null,
            'unit_layout' => $this->unit_layout ? storage_url($this->unit_layout) : null,
            'neighborhood_certificate' => $this->neighborhood_certificate ? storage_url($this->neighborhood_certificate) : null,
            'power_of_attorney' => $this->power_of_attorney ? storage_url($this->power_of_attorney) : null,
            'permit_letter' => $this->permit_letter ? storage_url($this->permit_letter) : null,
            'deposit_statement' => $this->deposit_statement ? storage_url($this->deposit_statement) : null,
            'neighbor_information' => $this->neighbor_information ? storage_url($this->neighbor_information) : null,
            'status' => $this->status,
            'notes' => $this->notes
        ];
    }
}
