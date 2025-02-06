<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailBillResource extends JsonResource
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
            'type' => $this->whenLoaded('billType') ? [
                'id' => (int)$this->bill_type_id,
                'name' => @$this->billType->name,
            ] : null,
            'title' => $this->title,
            'total_bill' => $this->value,
            'start_value' => $this->start_value,
            'end_value' => $this->end_value,
            'billed_at' => $this->billed_at->format('Y-m-d'),
            'usage_period_at' => $this->usage_period_at->format('Y-m-d'),
            'tax' => $this->tax,
            'penalty' => $this->penalty,
            'discount' => $this->discount,
            'bill_release' => $this->bill_release,
            'penalty_release' => $this->penalty_release,
            'paid' => $this->paid,
            'total' => $this->total,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
