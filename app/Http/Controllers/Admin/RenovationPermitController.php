<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RenovationPermit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RenovationPermitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.renovation_permits.index');
    }

    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;

        $permits = RenovationPermit::select('renovation_permits.*')->with([
            'user:id,name',
            'projectunit:name,id',
        ]);
        if ($developer_id) {
            $permits->where('developer_id', $developer_id);
        }
        if ($request->status) {
            $permits->where('status', $request->status);
        }
        return DataTables::of($permits)
            ->addIndexColumn()
            ->editColumn('type', function ($row) {
                return strtoupper($row->type);
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'request') {
                    return '<span class="text-warning"><i class="fas fa-history"></i> Menunggu</span>';
                }
                if ($row->status == 'reject') {
                    return '<span class="text-warning"><i class="far fa-times-circle"></i> Ditolak</span>';
                }
                return '<span class="text-success"><i class="far fa-check-circle"></i> Diterima</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = view('datatables.renovation_permits.action', compact('row'))->render();
                return $btn;
            })
            ->editColumn('id_card_photo', function ($row) {
                $file = @$row->id_card_photo;
                return $file ? '<a href="' . storage_url($file) . '" class="btn-sm text-xs btn-link" target="_blank">File KTP <i class="fas fa-long-arrow-alt-right"></i></a>' : null;
            })
            ->rawColumns(['status', 'action', 'id_card_photo'])
            ->toJson();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permit = RenovationPermit::with([
            'user:id,name',
            'projectunit:name,id',
        ])->find($id);
        return view('pages.renovation_permits.detail', compact('permit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
