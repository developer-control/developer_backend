<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmergencyRequest;
use App\Models\EmergencyNumber;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EmergencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage emergency']);
    }
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(Request $request)
    {
        return view('pages.emergency_numbers.index', compact('request'));
    }

    public function emergencyDatatable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $emergency_numbers = EmergencyNumber::select('emergency_numbers.*')->with(['project:id,name']);
        if ($developer_id) {
            $emergency_numbers->where('developer_id', $developer_id);
        }
        if ($request->project_id) {
            $emergency_numbers->where('project_id', $request->project_id);
        }
        return DataTables::eloquent($emergency_numbers)
            ->editColumn('project.name', function (EmergencyNumber $emergency) {
                return @$emergency->project->name;
            })
            ->addColumn('action', function (EmergencyNumber $emergency) {
                $btn = view('datatables.emergency_numbers.action', compact('emergency'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new emergency to database
     * 
     * @param  EmergencyRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(EmergencyRequest $request)
    {
        $project = Project::find($request->project_id);
        if (!$project) {
            toast('Project not found', 'error');
            return back();
        }
        EmergencyNumber::create([
            'developer_id' => $project->developer_id,
            'project_id' => $request->project_id,
            'title' => $request->title,
            'number' => $request->number,
            'created_by' => Auth::user()->id,
        ]);
        toast('New emergency number has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  EmergencyRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(EmergencyRequest $request, string $id)
    {
        $project = Project::find($request->project_id);
        if (!$project) {
            toast('Project not found', 'error');
            return back();
        }

        $emergency = EmergencyNumber::find($id);
        $emergency->developer_id = $project->developer_id;
        $emergency->project_id = $request->project_id;
        $emergency->title = $request->title;
        $emergency->number = $request->number;
        $emergency->save();

        toast('Emergency number has been updated', 'success');
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
        EmergencyNumber::destroy($id);
        toast('Emergency number has been deleted', 'success');
        return back();
    }
}
