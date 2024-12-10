<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\UserUnit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserUnitController extends Controller
{
    public function queryUserUnit(Request $request)
    {
        $units = UserUnit::select('user_units.*')->with([
            'developer:name,id',
            'project:name,id',
            'projectArea:name,id',
            'projectBloc:name,id',
            'projectUnit:name,id',
            'city:name,id',
            'ownershipUnit:name,id',
            'user: id,name'
        ]);
        if ($request->status) {
            $units->where('status', $request->status);
        }
        return $units;
    }

    public function historyRequestDatatable(Request $request)
    {
        $units = $this->queryUserUnit($request);
        return DataTables::eloquent($units)
            ->addIndexColumn()
            ->toJson();
    }
    public function indexRequest()
    {
        return view('pages.project_units.request');
    }

    public function requestDatatable(Request $request)
    {
        $request->merge(['status' => 'request']);
        $developer_id = auth()->user()->hasRole('superadmin') ? null : auth()->user()->developer_id;

        $units = $this->queryUserUnit($request);
        if ($developer_id) {
            $units->where('developer_id', $developer_id);
        }
        return DataTables::eloquent($units)
            ->addIndexColumn()
            ->toJson();
    }
}
