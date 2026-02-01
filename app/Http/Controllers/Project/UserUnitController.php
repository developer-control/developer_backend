<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\OwnershipUnit;
use App\Models\UserUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserUnitController extends Controller
{
    const ROUTE = 'unit.request.';
    const PERMISSION = 'unit>request>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
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
            ->editColumn('status', function (UserUnit $unit) {
                if ($unit->status == 'request') {
                    return '<span class="text-warning"><i class="fas fa-history"></i> Menunggu Konfirmasi</span>';
                }
                if ($unit->status == 'failed') {
                    return '<span class="text-danger"><i class="far fa-times-circle"></i> Menunggu Konfirmasi</span>';
                }
                return '<span class="text-success"><i class="far fa-check-circle"></i> Disetujui</span>';
            })
            ->rawColumns(['status'])
            ->toJson();
    }

    public function indexRequest()
    {
        $ownerships = OwnershipUnit::all();
        return view('pages.project_units.request', compact('ownerships'));
    }

    public function indexHistoryRequest(Request $request)
    {
        return view('pages.project_units.request_history', compact('request'));
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
                return $unit->evidence_file ? '<a href="' . storage_url($unit->evidence_file) . '" class="btn-sm text-xs btn-link" target="_blank">File Bukti <i class="fas fa-long-arrow-alt-right"></i></a>' : null;
            })
            ->addColumn('action', function (UserUnit $unit) {
                $btn = view('datatables.project_units.request_action', compact('unit'))->render();
                return $btn;
            })
            ->rawColumns(['evidence_file', 'action'])
            ->make(true);
    }

    public function updateApprove(string $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $unit = UserUnit::findOrFail($id);
            $oldUnit = UserUnit::where('ownership_unit_id', $unit->ownership_unit_id)
                ->where('project_unit_id', $unit->project_unit_id)
                ->where('status', 'claimed')
                ->where('is_active', 1)
                ->where('id', '<>', $id)
                ->first();
            if ($oldUnit) {
                throw new \Exception('Unit sudah di klaim dengan status kepimilikan yang sama');
            }
            $unit->status = 'claimed';
            $unit->is_active = 1;
            $unit->verified_by = Auth::user()->id;
            $unit->verified_at = now();
            $unit->save();
            UserUnit::where('id', '<>', $id)
                ->where('ownership_unit_id', $unit->ownership_unit_id)
                ->where('project_unit_id', $unit->project_unit_id)
                ->where('status', 'request')
                ->where('is_active', 0)
                ->update([
                    'status' => 'failed',
                    'notes' => 'Unit yang anda ajukan sudah klaim user lain, mohon hubungi developer untuk info lebih lanjut',
                    'verified_by' => Auth::user()->id,
                    'verified_at' => now()
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back();
        }
        toast('Klaim unit berhasil di setujui', 'success');
        return back();
    }

    public function updateReject(string $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $unit = UserUnit::find($id);

            $unit->status = 'reject';
            $unit->notes = $request->notes;
            $unit->verified_by = Auth::user()->id;
            $unit->verified_at = now();
            $unit->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back();
        }
        toast('Klaim unit berhasil di tolak', 'success');
        return back();
    }
}
