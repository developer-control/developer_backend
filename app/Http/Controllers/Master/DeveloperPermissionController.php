<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class DeveloperPermissionController extends Controller
{
    const ROUTE = 'developer.permission.';
    const PERMISSION = 'developer>permission>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
    /**
     * Display a listing of the resource.
     */
    public function edit(Developer $developer)
    {
        $permissions = Permission::orderBy('menu', 'asc')
            ->orderBy('group', 'asc')
            ->get();
        $permissions = $permissions->groupBy(['menu']);
        return view('pages.master.developers.permission', compact('developer', 'permissions'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $developer->syncPermissions($request->permissions);
        toast('Permission has been added to developer', 'success');
        return back();
    }
}
