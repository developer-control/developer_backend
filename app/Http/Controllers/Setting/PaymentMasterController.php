<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMasterRequest;
use App\Models\PaymentMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.master.payment_settings.index');
    }

    public function dataTable(Request $request)
    {
        $settings = PaymentMaster::query();
        return DataTables::of($settings)
            ->addColumn('action', function ($row) {
                return view('datatables.payment_masters.action', compact('row'))->render();
            })
            ->editColumn('description', function ($row) {
                return str($row->description)->limit(65);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMasterRequest $request)
    {
        $validatedData = $request->validated();
        PaymentMaster::create($validatedData);
        toast('New master payment has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMasterRequest $request, string $id)
    {
        $term = PaymentMaster::findOrFail($id);
        // Mengambil data yang sudah divalidasi
        $validatedData = $request->validated();

        // Mengupdate data term
        $term->update($validatedData);
        toast('Master payment has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PaymentMaster::destroy($id);
        toast('Master Payment has been deleted', 'success');
        return back();
    }
}
