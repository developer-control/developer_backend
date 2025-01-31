<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillTypeRequest;
use App\Models\BillType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BillTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage bill type']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.master.bill_types.index');
    }


    public function billTypeDatatable(Request $request)
    {
        $types = BillType::query();

        return DataTables::of($types)
            ->editColumn('is_edit', function ($row) {
                return @$row->is_edit ? 'iya' : 'tidak';
            })
            ->editColumn('with_start_value', function ($row) {
                return @$row->with_start_value ? 'iya' : 'tidak';
            })
            ->addColumn('action', function ($row) {
                $btn = view('datatables.bill_types.action', compact('row'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BillTypeRequest $request)
    {
        BillType::create($request->all());
        toast('New bill type has been created', 'success');
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillTypeRequest $request, string $id)
    {
        $type = BillType::find($id);
        $type->update($request->all());
        toast('Bill type has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BillType::destroy($id);
        toast('Bill type has been deleted', 'success');
        return back();
    }
}
