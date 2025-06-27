<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBlocRequest;
use App\Models\ProjectArea;
use App\Models\ProjectBloc;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlocController extends Controller
{
    const ROUTE = 'bloc.';
    const PERMISSION = 'bloc>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(Request $request)
    {
        return view('pages.project_blocs.index', compact('request'));
    }

    public function blocDatatable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $project_blocs = ProjectBloc::select('project_blocs.*')->with(['projectarea']);
        if ($developer_id) {
            $project_blocs->where('developer_id', $developer_id);
        }
        if ($request->project_area_id) {
            $project_blocs->where('project_area_id', $request->project_area_id);
        }
        return DataTables::eloquent($project_blocs)
            ->editColumn('projectarea.name', function (ProjectBloc $bloc) {
                return @$bloc->projectarea->name;
            })
            ->addColumn('action', function (ProjectBloc $bloc) {
                $btn = view('datatables.project_blocs.action', compact('bloc'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new bloc to database
     * 
     * @param  ProjectBlocRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ProjectBlocRequest $request)
    {
        $area = ProjectArea::find($request->project_area_id);
        if (!$area) {
            toast('Project area not found', 'error');
            return back();
        }
        ProjectBloc::create([
            'developer_id' => $area->developer_id,
            'project_area_id' => $request->project_area_id,
            'name' => $request->name,
        ]);
        toast('New bloc has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  ProjectBlocRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(ProjectBlocRequest $request, string $id)
    {
        $area = ProjectArea::find($request->project_area_id);
        if (!$area) {
            toast('Project area not found', 'error');
            return back();
        }

        $bloc = ProjectBloc::find($id);
        $bloc->developer_id = $area->developer_id;
        $bloc->project_area_id = $request->project_area_id;
        $bloc->name = $request->name;
        $bloc->save();

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
        ProjectBloc::destroy($id);
        toast('Area has been deleted', 'success');
        return back();
    }

    public function optionBloc(Request $request)
    {
        $projects = ProjectBloc::select('id', 'name');
        if (!$request->user()->hasRole('superadmin')) {
            $projects->where('developer_id', $request->user()->developer_id);
        }

        if ($request->limit) {
            $projects->limit($request->limit);
        }
        $results = $projects->get();
        return ApiResponse::success($results, 'Get option project bloc success.');
    }
}
