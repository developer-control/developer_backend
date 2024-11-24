<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('pages.master.role');
    }
    public function roleDatatable(Request $request)
    {
        $roles = Role::query();
        if (!Auth::user()->hasRole('superadmin')) {
            $roles->where('developer_id', Auth::user()->developer_id);
        }
        return DataTables::eloquent($roles)
            ->addIndexColumn()
            ->toJson();
    }
}
