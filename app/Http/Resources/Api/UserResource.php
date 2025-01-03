<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image ? storage_url($this->image) : null,
            'id_card_image' => $this->id_card_image ? storage_url($this->id_card_image) : null,
            'identity_number' => $this->identity_number,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
