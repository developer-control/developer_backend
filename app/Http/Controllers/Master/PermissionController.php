<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.master.permissions.index');
    }

    /**
     * get datatable resource for role access master.
     */
    public function permissionDatatable(Request $request)
    {
        $permissions = Permission::query();

        return DataTables::eloquent($permissions)
            ->addColumn('action', function (Permission $permission) {
                $btn = view('datatables.permissions.action', compact('permission'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        toast('New permission has been created', 'success');
        return back();
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, string $id)
    {
        $permission = Permission::find($id);
        $permission->update([
            'name' => $request->name,
        ]);
        toast('Permission has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        // Hapus semua relasi dengan user dan permission

        $permission->roles()->detach();  // Hapus relasi dengan permission
        $permission->delete();
        toast('Permission has been deleted', 'success');
        return back();
    }
}
