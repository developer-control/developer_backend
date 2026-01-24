<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DetailBillQuery;
use App\Http\Resources\Api\DetailBillResource;
use App\Http\Resources\Api\ListBillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Get Total Tagihan Unit
     *
     * api for get total bill from unit 
     *
     * @param  string  $slug
     * @param  string  $unit_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTotalBill(string $slug, string $unit_id)
    {
        $bills = Bill::where('project_unit_id', $unit_id)
            ->where('status', 'not_paid')
            ->sum('total');
        return ApiResponse::success(['total' => $bills ?? 0], 'Get total bill success');
    }
    /**
     * Get List Tagihan Unit
     *
     * api for get total bill from unit that have not yet been issued
     *
     * @param  string  $slug
     * @param  string  $unit_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(string $slug, string $unit_id)
    {
        $bills = Bill::where('project_unit_id', $unit_id)
            ->where('status', 'not_paid')
            ->selectRaw('billed_at, SUM(total) as total_bill')
            ->groupBy('billed_at');
        $results = $bills->get();
        return ApiResponse::success(ListBillResource::collection($results), 'Get list bill success');
    }
    /**
     * Get List Detail Tagihan Unit
     *
     * api for get total bill from unit that have not yet been issued
     *
     * @param  string  $unit_id
     * @param  \App\Http\Requests\Api\DetailBillQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showListBill(string $slug, string $unit_id, DetailBillQuery $request)
    {
        $bills = Bill::where('project_unit_id', $unit_id)
            ->whereMonth('billed_at', $request->month)
            ->whereYear('billed_at', $request->year)
            // ->where('status', 'not_paid')
            ->with([
                'billType:id,name'
            ]);
        if ($request->filled('invoice_code')) {
            $bills->whereHas('payments', function ($q) use ($request) {
                $q->where('payments.invoice_code', $request->invoice_code);
            });
        } else {
            $bills->where('status', 'not_paid');
        }
        $results = $bills->get();
        return ApiResponse::success(DetailBillResource::collection($results), 'Get list detail bill success');
    }
}
