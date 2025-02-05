<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ComplainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage complain']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.complains.index', compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;

        $complains = Complain::select('complains.*')->with([
            'user:id,name'
        ]);
        if ($developer_id) {
            $complains->where('developer_id', $developer_id);
        }
        if ($request->status) {
            $complains->where('status', $request->status);
        }
        return DataTables::of($complains)
            ->addIndexColumn()
            ->editColumn('type', function ($row) {
                return strtoupper($row->type);
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'request') {
                    return '<span class="text-warning"><i class="fas fa-history"></i> Menunggu</span>';
                }

                return '<span class="text-success"><i class="far fa-check-circle"></i> Diselesaikan</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = view('datatables.complains.action', compact('row'))->render();
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complain = Complain::with([
            'project:name,id',
            'projectarea:name,id',
            'projectunit:name,id',
            'user:id,name',
        ])
            ->find($id);
        return view('pages.complains.detail', compact('complain'));
    }

    /**
     * Update Solve complain by User.
     * 
     * api for user update complain to solved that problem
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSolve(Request $request, int $id)
    {
        $complain = Complain::find($id);
        $request->validate(['solved_notes' => 'required']);
        if ($complain->status == 'finished') {
            toast('Komplain', 'error');
            return back();
        }
        try {
            DB::beginTransaction();
            $complain->status = 'finished';
            $complain->solved_notes = $request->solved_notes;
            $complain->solved_by = $request->user()->id;
            $complain->solved_at = NOW();
            $complain->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back();
        }
        toast('Komplain berhasil di selesaikan', 'success');
        return back();
    }
}
