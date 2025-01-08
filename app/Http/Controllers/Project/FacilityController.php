<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FacilityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage facility']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.facilities.index', compact('request'));
    }

    public function facilityDatatable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $facilities = Facility::select('facilities.*')->with(['project:id,name']);
        if ($developer_id) {
            $facilities->where('developer_id', $developer_id);
        }
        if ($request->project_id) {
            $facilities->where('project_id', $request->project_id);
        }

        return DataTables::eloquent($facilities)
            ->editColumn('project.name', function (Facility $facility) {
                return @$facility->project->name;
            })
            ->editColumn('is_active', function (Facility $facility) {
                return @$facility->is_active ? 'Aktif' : 'Tidak Aktif';
            })
            ->addColumn('action', function (Facility $facility) {
                $btn = view('datatables.facilities.action', compact('facility'))->render();
                return $btn;
            })
            ->addColumn('title_view', function (Facility $facility) {
                return view('datatables.facilities.title', compact('facility'))->render();
            })
            ->rawColumns(['action', 'title_view'])
            ->addIndexColumn()
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacilityRequest $request)
    {
        DB::transaction(function () use ($request) {
            $project = Project::find($request->project_id);
            $developer_id = $request->user()->hasRole('superadmin') ? $project->developer_id : $request->user()->developer_id;
            $promtion = Facility::create([
                'developer_id' => @$developer_id,
                'project_id' => @$project->id,
                'title' => $request->title,
                'image' => $request->image,
                'description' => $request->description,
                'created_by' => $request->user()->id,
                'is_active' => $request->is_active ? 1 : 0
            ]);
            //get media
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $promtion->media()->attach($image, ['type' => 'image']);
            }
        });
        toast('New Facility has been created', 'success');
        return redirect()->route('menu_facility');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facility = Facility::find($id);
        return view('pages.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacilityRequest $request, string $id)
    {
        $facility = Facility::find($id);
        $old_image = $facility->image;
        if ($old_image != $request->image) {
            remove_file($old_image, $facility);
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $facility->media()->attach($image, ['type' => 'image']);
            }
        }
        $facility->project_id = $request->project_id;
        $facility->title = $request->title;
        $facility->image = $request->image;
        $facility->description = $request->description;
        $facility->is_active = $request->is_active ? 1 : 0;
        $facility->save();
        toast('Facility has been updated', 'success');
        return redirect()->route('menu_facility');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facility = Facility::find($id);
        if ($facility->image) {
            remove_file($facility->image, $facility);
        }
        Facility::destroy($id);
        toast('Facility has been deleted', 'success');
        return back();
    }
}
