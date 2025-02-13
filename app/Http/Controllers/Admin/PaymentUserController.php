<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.payments.index', compact('request'));
    }

    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $payments = Payment::select('payments.*')->with([
            'user:id,name',
            'projectunit:id,name',
            'paymentdata:id,payment_id,file_url'
        ]);
        if ($developer_id) {
            $payments->where('developer_id', $developer_id);
        }
        if ($request->status) {
            $payments->where('status', $request->status);
        }
        return DataTables::of($payments)
            ->addIndexColumn()
            ->editColumn('total', function ($row) {
                return number_format($row?->total);
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'pending') {
                    return '<span class="text-info"><i class="fas fa-info-circle"></i> Menunggu Pembayaran</span>';
                }
                if ($row->status == 'cancel') {
                    return '<span class="text-danger"><i class="far fa-times-circle"></i> Dibatalkan</span>';
                }
                if ($row->status == 'request') {
                    return '<span class="text-warning"><i class="fas fa-history"></i>Menunggu Validasi</span>';
                }
                if ($row->status == 'reject') {
                    return '<span class="text-danger"><i class="far fa-times-circle"></i> Ditolak</span>';
                }
                return '<span class="text-success"><i class="far fa-check-circle"></i> Selesai</span>';
            })
            ->addColumn('file_payment', function ($row) {
                $file = @$row->paymentdata->file_url;
                return $file ? '<a href="' . storage_url($file) . '" class="btn-sm text-xs btn-link" target="_blank">File Bukti <i class="fas fa-long-arrow-alt-right"></i></a>' : null;;
            })
            ->addColumn('action', function ($row) {
                // $btn = view('datatables.bills.action', compact('row'))->render();
                return 'tes';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
