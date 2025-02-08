<?php

namespace App\Http\Resources\Api;

use App\Models\PaymentData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $groupedBills = $this->bills
            ->groupBy('billed_at')
            ->map(function ($bills, $date) {
                return [
                    'billed_at' => date_format(date_create($date), 'Y-m-d'),
                    'total_bill' => $bills->sum('total'),
                ];
            })->values();
        return [
            'id' => (int)$this->id,
            'invoice_code' => $this->invoice_code,
            'status' => $this->status,
            'date' => $this->date,
            'total' => $this->total,
            'bills' => $this->whenLoaded('bills') ? $groupedBills : [],
            'payment_data' => $this->whenLoaded('paymentData') ? new PaymentDataResource($this->paymentData) : null,
        ];
    }
}
