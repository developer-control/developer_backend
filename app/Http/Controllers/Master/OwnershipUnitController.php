<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OwnershipUnitRequest;
use App\Models\OwnershipUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OwnershipUnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage ownership unit']);
    }
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(Request $request)
    {
        return view('pages.master.ownership_units.index', compact('request'));
    }

    public function ownershipDatatable(Request $request)
    {
        $ownership_units = OwnershipUnit::select('ownership_units.*');
        return DataTables::eloquent($ownership_units)
            ->addColumn('action', function (OwnershipUnit $ownership) {
                $btn = view('datatables.ownership_units.action', compact('ownership'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new ownership to database
     * 
     * @param  OwnershipUnitRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(OwnershipUnitRequest $request)
    {

        OwnershipUnit::create([
            'name' => $request->name,
        ]);
        toast('New ownership has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  OwnershipUnitRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(OwnershipUnitRequest $request, string $id)
    {

        $ownership = OwnershipUnit::find($id);
        $ownership->name = $request->name;
        $ownership->save();

        toast('Ownership has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  string $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function destroy(string $id)
    {
        OwnershipUnit::destroy($id);
        toast('Area has been deleted', 'success');
        return back();
    }

    public function optionArea(Request $request)
    {
        $ownership = OwnershipUnit::select('id', 'name');
        if ($request->limit) {
            $ownership->limit($request->limit);
        }
        $results = $ownership->get();
        return ApiResponse::success($results, 'Get option project ownership success.');
    }
}
