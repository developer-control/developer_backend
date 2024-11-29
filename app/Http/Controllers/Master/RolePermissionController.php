<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RolePermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage role']);
    }

    /**
     * Display page Role Access Master.
     */
    public function index()
    {
        // $developers = Developer::all();
        return view('pages.master.roles.index');
    }

    /**
     * get datatable resource for role access master.
     */
    public function roleDatatable(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $roles = Role::query();
        if (!$user->hasRole('superadmin')) {
            $roles->where('developer_id', Auth::user()->developer_id);
        }
        return DataTables::eloquent($roles)
            ->addColumn('action', function (Role $role) {
                $btn = view('datatables.roles.action', compact('role'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new role access master
     * 
     * @param  StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     * 
     */

    public function store(StoreRoleRequest $request)
    {
        if ($request->developer_id) {
            $developer = Developer::find($request->developer_id);
            $name = @$developer ? $request->name . ' ' . $developer->name : $request->name;
        }
        $role = Role::create([
            'developer_id' => $request->developer_id,
            'name' => @$name ?? $request->name,
            'guard_name' => 'web',
        ]);
        toast('New role has been created', 'success');
        return back();
    }

    /**
     * update role access master
     * 
     * @param  StoreRoleRequest  $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     * 
     */

    public function update(StoreRoleRequest $request, string $id)
    {
        $role = Role::find($id);
        $role->developer_id = $request->developer_id;
        $role->name = $request->name;
        $role->save();

        toast('Role has been updated', 'success');
        return back();
    }

    /**
     * delete role access master
     * 
     * @param  string $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        // Hapus semua relasi dengan user dan permission
        $role->users()->detach();        // Hapus relasi dengan user
        $role->permissions()->detach();  // Hapus relasi dengan permission
        $role->delete();
        toast('Role has been deleted', 'success');
        return back();
    }
}
