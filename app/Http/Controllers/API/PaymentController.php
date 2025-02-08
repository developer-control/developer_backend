<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentQuery;
use App\Http\Resources\Api\DetailPaymentResource;
use App\Http\Resources\Api\DeveloperBankResource;
use App\Http\Resources\Api\PaymentResource;
use App\Http\Resources\Api\StorePaymentResource;
use App\Models\DeveloperBank;
use App\Models\Payment;
use App\Models\ProjectUnit;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {

        $this->paymentService = $paymentService;
    }
    /**
     * Get Payment History.
     * 
     * api for get Payment history data from database
     *
     * @param  string $unit_id
     * @param  \App\Http\Requests\Api\PaymentQuery $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(string $unit_id, PaymentQuery $request)
    {
        $limit = $request->limit ?? 6;
        $payments = Payment::where('project_unit_id', $unit_id);

        if ($request->status) {
            $payments->where('status', $request->status);
        }
        if ($request->search) {
            $payments->where('invoice_code', 'LIKE', "%{$request->search}%");
        }
        $results = $payments->latest()->paginate($limit);
        return ApiResponse::success(PaymentResource::collection($results), 'Get history payment for units success.');
    }

    /**
     * Detail History Payment.
     * 
     * api for detail of payment from database
     *
     * @param  string $unit_id
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $unit_id, string $id)
    {
        $payment = Payment::with(['bills', 'paymentData', 'paymentData.developerBank'])
            ->where('project_unit_id', $unit_id)
            ->where('id', $id)->first();
        // dd($payment);
        if (!$payment) {
            return ApiResponse::error('payment unit user not found', 404);
        }

        return ApiResponse::success(new DetailPaymentResource($payment), 'get detail payment unit user success');
    }


    /**
     * Store Payment Unit.
     * 
     * api for user store payment unit request
     *
     * @param  string $unit_id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(string $unit_id, Request $request)
    {
        $request->validate(['billed_at' => 'required|array']);
        try {
            DB::beginTransaction();
            $unit = ProjectUnit::find($unit_id);
            $user_id  = $request->user()->id;
            $invoice_code = $this->paymentService->generateInvoiceCode($user_id, $unit_id);
            $payment = Payment::create([
                'user_id' => $user_id,
                'project_unit_id' => $unit_id,
                'developer_id' => $unit->developer_id,
                'invoice_code' => $invoice_code,
                'date' => date('Y-m-d'),
                'status' => 'request',
                'total' => $this->paymentService->getBill($unit_id, $request->billed_at)->sum('total'),
            ]);
            $bills = $this->paymentService->getBill($unit_id, $request->billed_at)->pluck('id');
            $payment->bills()->sync($bills);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ApiResponse::error($th->getMessage(), 500);
        }

        return ApiResponse::success(new StorePaymentResource($payment), 'Create payment unit success', 200);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function indexBank(string $unit_id)
    {
        $unit = ProjectUnit::find($unit_id);
        $banks = DeveloperBank::where('developer_id', $unit->developer_id)->get();
        return ApiResponse::success(new DeveloperBankResource($banks), 'Get master developer bank success', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
