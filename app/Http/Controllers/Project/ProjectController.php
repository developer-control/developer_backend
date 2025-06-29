<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    const ROUTE = 'project.';
    const PERMISSION = 'project>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }

    public function index()
    {
        return view('pages.projects.index');
    }
    /**
     * get datatable resource for role access master.
     */
    public function projectDatatable(Request $request)
    {

        $projects = Project::select('projects.*')->with(['city']);

        if (!$request->user()->hasRole('superadmin')) {
            $projects->where('developer_id', $request->user()->developer_id);
        }
        return DataTables::eloquent($projects)

            ->editColumn('city.name', function (Project $project) {
                return @$project->city->name;
            })
            ->addColumn('action', function (Project $project) {
                $btn = view('datatables.projects.action', compact('project'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new project to database
     * 
     * @param  ProjectRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ProjectRequest $request)
    {
        Project::create([
            'city_id' => $request->city_id,
            'developer_id' => $request->developer_id ?? $request->user()->developer_id,
            'name' => $request->name,
        ]);
        toast('New project has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  ProjectRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(ProjectRequest $request, string $id)
    {
        $project = Project::find($id);
        $project->city_id = $request->city_id;
        $project->developer_id = $request->developer_id ?? $project->developer_id;
        $project->name = $request->name;
        $project->save();

        toast('Project has been updated', 'success');
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
        Project::destroy($id);
        toast('Project has been deleted', 'success');
        return back();
    }

    public function optionProject(Request $request)
    {
        $projects = Project::select('id', 'name');
        if (!$request->user()->hasRole('superadmin')) {
            $projects->where('developer_id', $request->user()->developer_id);
        }

        if ($request->limit) {
            $projects->limit($request->limit);
        }
        $results = $projects->get();
        return ApiResponse::success($results, 'Get option project success.');
    }
}
