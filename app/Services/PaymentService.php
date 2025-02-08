<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    function generateInvoiceCode($user_id, $unit_id)
    {
        return DB::transaction(function () use ($user_id, $unit_id) {
            do {
                $code = now()->format('YmdHisv');
                // Format invoice code
                $invoiceCode = "INV-{$user_id}{$unit_id}-{$code}";
                // Cek apakah kode sudah ada di database
                $exists = Payment::where('invoice_code', $invoiceCode)->exists();
            } while ($exists); // Jika sudah ada, generate ulang

            return $invoiceCode;
        });
    }
    function getBill(string $unit_id, array $billed_at)
    {
        return  Bill::where('project_unit_id', $unit_id)
            ->whereIn('billed_at', $billed_at)
            ->where('status', 'not_paid');
    }
}
