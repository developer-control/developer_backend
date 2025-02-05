<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUnitRequest;
use App\Models\ProjectBloc;
use App\Models\ProjectUnit;
use App\Models\UserUnit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage unit']);
    }
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(Request $request)
    {
        return view('pages.project_units.index', compact('request'));
    }

    public function unitDatatable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $project_units = ProjectUnit::select('project_units.*')->with(['projectbloc', 'unitactive']);
        if ($developer_id) {
            $project_units->where('developer_id', $developer_id);
        }
        if ($request->project_bloc_id) {
            $project_units->where('project_bloc_id', $request->project_bloc_id);
        }
        if ($request->status == 'claimed') {
            $project_units->has('unitActive');
        }
        if ($request->status == 'not_claimed') {
            $project_units->doesntHave('unitActive');
        }
        return DataTables::eloquent($project_units)
            ->editColumn('projectbloc.name', function (ProjectUnit $unit) {
                return @$unit->projectbloc->name;
            })
            ->addColumn('action', function (ProjectUnit $unit) {
                $btn = view('datatables.project_units.action', compact('unit'))->render();
                return $btn;
            })
            ->addColumn('has_claimed', function (ProjectUnit $unit) {
                return $unit->unitactive ? 'Sudah diklaim' : 'Belum diklaim';
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new bloc to database
     * 
     * @param  ProjectUnitRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ProjectUnitRequest $request)
    {
        $bloc = ProjectBloc::find($request->project_bloc_id);
        if (!$bloc) {
            toast('Project bloc not found', 'error');
            return back();
        }
        ProjectUnit::create([
            'developer_id' => $bloc->developer_id,
            'project_bloc_id' => $request->project_bloc_id,
            'name' => $request->name,
        ]);
        toast('New unit has been created', 'success');
        return back();
    }

    /**
     * Display a listing of the resource.
     * 
     */
    public function show(string $id)
    {
        $unit = ProjectUnit::with([
            'projectBloc:name,id,project_area_id',
            'projectBloc.projectArea:name,id,project_id',
            'projectBloc.projectArea.project:name,id',
        ])
            ->find($id);
        $userUnit = UserUnit::with(['user'])
            ->where('project_unit_id', $id)
            ->where('is_active', 1)
            ->where('status', 'claimed')
            ->whereHas('ownershipUnit', function ($q) {
                $q->where('name', 'like', 'pemilik');
            })
            ->first();
        return view('pages.project_units.detail', compact('unit', 'userUnit'));
    }

    /**
     * Update the specified resource in storage.
     * 
     *  @param  ProjectUnitRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(ProjectUnitRequest $request, string $id)
    {
        $bloc = ProjectBloc::find($request->project_bloc_id);
        if (!$bloc) {
            toast('Project bloc not found', 'error');
            return back();
        }

        $bloc = ProjectUnit::find($id);
        $bloc->developer_id = $bloc->developer_id;
        $bloc->project_bloc_id = $request->project_bloc_id;
        $bloc->name = $request->name;
        $bloc->save();

        toast('Unit has been updated', 'success');
        return back();
    }

    public function optionUnit(Request $request)
    {
        $units = ProjectUnit::select('id', 'name');
        if (!$request->user()->hasRole('superadmin')) {
            $units->where('developer_id', $request->user()->developer_id);
        }

        if ($request->limit) {
            $units->limit($request->limit);
        }
        $results = $units->get();
        return ApiResponse::success($results, 'Get option project unit success.');
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
        ProjectUnit::destroy($id);
        toast('Unit has been deleted', 'success');
        return back();
    }
}
