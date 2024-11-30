<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectAreaRequest;
use App\Models\Project;
use App\Models\ProjectArea;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage area']);
    }
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(Request $request)
    {
        return view('pages.project_areas.index', compact('request'));
    }

    public function areaDatatable(Request $request)
    {
        $developer_id = auth()->user()->hasRole('superadmin') ? null : auth()->user()->developer_id;
        $project_areas = ProjectArea::select('project_areas.*')->with(['project']);
        if ($developer_id) {
            $project_areas->where('developer_id', $developer_id);
        }
        if ($request->project_id) {
            $project_areas->where('project_id', $request->project_id);
        }
        return DataTables::eloquent($project_areas)
            ->editColumn('area.name', function (ProjectArea $area) {
                return @$area->area->name;
            })
            ->addColumn('action', function (ProjectArea $area) {
                $btn = view('datatables.project_areas.action', compact('area'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new area to database
     * 
     * @param  ProjectAreaRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ProjectAreaRequest $request)
    {
        $project = Project::find($request->project_id);
        if (!$project) {
            toast('Project not found', 'error');
            return back();
        }
        ProjectArea::create([
            'developer_id' => $project->developer_id,
            'project_id' => $request->project_id,
            'name' => $request->name,
        ]);
        toast('New area has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  ProjectAreaRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(ProjectAreaRequest $request, string $id)
    {
        $project = Project::find($request->project_id);
        if (!$project) {
            toast('Project not found', 'error');
            return back();
        }

        $area = ProjectArea::find($id);
        $area->developer_id = $project->developer_id;
        $area->project_id = $request->project_id;
        $area->name = $request->name;
        $area->save();

        toast('Area has been updated', 'success');
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
        ProjectArea::destroy($id);
        toast('Area has been deleted', 'success');
        return back();
    }

    public function optionArea(Request $request)
    {
        $projects = ProjectArea::select('id', 'name');
        if (!auth()->user()->hasRole('superadmin')) {
            $projects->where('developer_id', auth()->user()->developer_id);
        }

        if ($request->limit) {
            $projects->limit($request->limit);
        }
        $results = $projects->get();
        return ApiResponse::success($results, 'Get option project area success.');
    }
}
