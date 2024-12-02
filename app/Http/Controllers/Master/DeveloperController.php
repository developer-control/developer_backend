<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeveloperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage developer']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.master.developers.index');
    }

    /**
     * get datatable resource for role access master.
     */
    public function developerDatatable(Request $request)
    {

        $developers = Developer::query();

        return DataTables::eloquent($developers)
            ->editColumn('province.name', function (Developer $developer) {
                return @$developer->province->name;
            })
            ->addColumn('action', function (Developer $developer) {
                $btn = view('datatables.developers.action', compact('developer'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new developer to database
     * 
     * @param  DeveloperRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(DeveloperRequest $request)
    {
        Developer::create([
            'name' => $request->name,
        ]);
        toast('New developer has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  DeveloperRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(DeveloperRequest $request, string $id)
    {
        $developer = Developer::find($id);
        $developer->name = $request->name;
        $developer->save();

        toast('Developer has been updated', 'success');
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
        Developer::destroy($id);
        toast('Developer has been deleted', 'success');
        return back();
    }
    public function optionDeveloper(Request $request)
    {
        $limit = $request->limit ?? 10;
        $developers = Developer::select('id', 'name');
        if ($request->search) {
            $developers->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->limit) {
            $developers->limit($request->limit);
        }
        $results = $developers->get();
        return ApiResponse::success($results, 'Get developers success.');
    }
}
