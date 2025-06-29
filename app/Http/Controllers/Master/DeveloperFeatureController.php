<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Feature;
use Illuminate\Http\Request;

class DeveloperFeatureController extends Controller
{
    const ROUTE = 'developer.feature.';
    const PERMISSION = 'developer>feature>';
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
        $features = Feature::all();
        return view('pages.master.developers.feature', compact('developer', 'features'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        // $developer->syncPermissions($request->permissions);
        $developer->features()->sync($request->features);
        toast('Features has been assign to developer', 'success');
        // toast('Permission has been added to developer', 'success');
        return back();
    }
}
