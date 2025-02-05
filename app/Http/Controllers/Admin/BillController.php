<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\BillType;
use App\Models\ProjectUnit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.bills.index', compact('request'));
    }

    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $bills = Bill::select('bills.*')
            ->with([
                'developer:id,name',
                'billtype:id,name',
                'projectunit:id,name'
            ]);
        if ($developer_id) {
            $bills->where('developer_id', $developer_id);
        }
        return DataTables::of($bills)
            ->addIndexColumn()
            ->editColumn('billtype.name', function ($row) {
                return strtoupper($row?->billtype->name);
            })
            ->editColumn('total', function ($row) {
                return number_format($row?->total);
            })
            ->editColumn('usage_period_at', function ($row) {
                return $row?->usage_period_at->format('F Y');
            })
            ->editColumn('billed_at', function ($row) {
                return $row?->billed_at->format('F Y');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'not_paid') {
                    return '<span class="text-warning"><i class="fas fa-history"></i> Belum bayar</span>';
                }
                if ($row->status == 'cancel') {
                    return '<span class="text-danger"><i class="far fa-times-circle"></i> Dibatalkan</span>';
                }

                return '<span class="text-success"><i class="far fa-check-circle"></i> Selesai</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = view('datatables.bills.action', compact('row'))->render();
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'billTypes' => BillType::all(),
        ];
        return view('pages.bills.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $request)
    {
        $billType = BillType::find($request->bill_type_id);
        $unit = ProjectUnit::find($request->project_unit_id);
        $request->merge([
            'developer_id' => $request->developer_id ?? $unit->developer_id,
            'title' => $billType->is_edit ? $request->title : $billType->name,
            'status' => 'not_paid'
        ]);
        Bill::create($request->all());
        toast('New bill has been created', 'success');
        return redirect()->route('menu_bill');
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
        $bill = Bill::find($id);
        if (!$bill) {
            return abort(404);
        }
        if ($bill->status != 'not_paid') {
            toast('Tagihan tidak bisa di edit karena status tidak sesuai', 'error');
            return redirect()->route('menu_bill');
        }
        $data = [
            'billTypes' => BillType::all(),
            'bill' => $bill
        ];
        return view('pages.bills.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillRequest $request, string $id)
    {
        $billType = BillType::find($request->bill_type_id);
        $unit = ProjectUnit::find($request->project_unit_id);
        $request->merge([
            'developer_id' => $request->developer_id ?? $unit->developer_id,
            'title' => $billType->is_edit ? $request->title : $billType->name,
            'status' => 'not_paid'
        ]);
        $bill = Bill::find($id);
        $bill->update($request->all());
        toast('Bill has been updated', 'success');
        return redirect()->route('menu_bill');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return abort(404);
        }
        if ($bill->status == 'paid') {
            toast('Tagihan tidak bisa di hapus karena sudah dibayarkan', 'error');
            return redirect()->route('menu_bill');
        }
        $bill->delete();
        toast('Bill has been deleted', 'success');
        return back();
    }
}
