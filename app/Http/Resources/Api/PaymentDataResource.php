<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDataResource extends JsonResource
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
            'developer_bank' => $this->whenLoaded('developerBank') ? new DeveloperBankResource($this->developerBank) : null,
            'bank_origin_name' => $this->bank_origin_name,
            'account_origin_name' => $this->account_origin_name,
            'account_origin_number' => $this->account_origin_number,
            'file_url' => $this->file_url ? storage_url($this->file_url) : null,
            'description' => $this->description,
            'paid_at' => $this->paid_at ? $this->paid_at->toDateTimeString() : null
        ];
    }
}
