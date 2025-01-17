<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage support']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.master.supports.index');
    }

    /**
     * get datatable resource for role access master.
     */
    public function supportDatatable(Request $request)
    {

        $supports = Support::select('supports.*')->with(['developer:id,name']);

        return DataTables::eloquent($supports)
            ->editColumn('developer.name', function (Support $support) {
                return @$support->developer->name;
            })
            ->editColumn('type', function (Support $support) {
                return ucwords(@$support->type);
            })
            ->addColumn('action', function (Support $support) {
                $btn = view('datatables.supports.action', compact('support'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new support to database
     * 
     * @param  SupportRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(SupportRequest $request)
    {
        Support::create([
            'developer_id' => $request->developer_id ?? $request->user()->developer_id,
            'title' => $request->title,
            'type' => $request->type,
            'value' => $request->value,
            'created_by' => Auth::user()->id,
        ]);
        toast('New support has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  SupportRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(SupportRequest $request, string $id)
    {
        $support = Support::find($id);
        $support->title = $request->title;
        $support->developer_id = $request->developer_id ?? $support->developer_id;
        $support->type = $request->type;
        $support->value = $request->value;
        $support->save();

        toast('Support has been updated', 'success');
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
        Support::destroy($id);
        toast('Support has been deleted', 'success');
        return back();
    }
}
