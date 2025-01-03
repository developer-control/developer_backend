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
            'projectarea:name,id',
            'projectbloc:name,id',
            'projectunit:name,id',
            'city:name,id',
            'ownershipunit:name,id',
            'user:id,name',
            'media:id,url'
        ]);
        if ($request->status) {
            $units->where('status', $request->status);
        }
        return $units;
    }

    public function historyRequestDatatable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;

        $units = $this->queryUserUnit($request);
        if ($developer_id) {
            $units->where('developer_id', $developer_id);
        }
        return DataTables::eloquent($units)
            ->addIndexColumn()
            ->addColumn('evidence_file', function (UserUnit $unit) {
                $evidence_file = $unit->media->first();
                return $evidence_file ? storage_url($evidence_file->url) : null;
            })
            ->addColumn('action', function (UserUnit $unit) {
                $btn = view('datatables.projects.action', compact('unit'))->render();
                return $btn;
            })
            ->toJson();
    }
    public function indexRequest()
    {
        return view('pages.project_units.request');
    }

    public function requestDatatable(Request $request)
    {
        $request->merge(['status' => 'request']);
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;

        $units = $this->queryUserUnit($request);
        if ($developer_id) {
            $units->where('developer_id', $developer_id);
        }
        return DataTables::eloquent($units)
            ->addIndexColumn()
            ->addColumn('evidence_file', function (UserUnit $unit) {
                $evidence_file = $unit->media->first();
                return $evidence_file ? '<a href="' . storage_url($evidence_file->url) . '" class="btn-sm text-xs btn-link" target="_blank">File Bukti <i class="fas fa-long-arrow-alt-right"></i></a>' : null;
            })
            ->rawColumns(['evidence_file'])
            ->make(true);
    }
}
