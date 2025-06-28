<?php

namespace App\Http\Controllers\Location;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Http\Resources\Api\ProvinceResource;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    const ROUTE = 'location.province.';
    const PERMISSION = 'location>province>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.locations.province');
    }

    public function initializeProvince()
    {
        $response = Http::get('https://wilayah.id/api/provinces.json');
        // return $response->object()->data;
        DB::beginTransaction();
        foreach (@$response->object()->data ?? [] as $province) {
            // dd($province->code);
            if (!Province::where('id', $province->code)->exists()) {
                // Jika email tidak ada, maka insert data
                Province::create([
                    'id' => $province->code,
                    'name' => $province->name
                ]);
            }
        }
        DB::commit();
        toast('Initialize Province Success', 'success');
        return back();
    }

    public function indexOption(Request $request)
    {

        $provinces = Province::select('id', 'name');
        if ($request->search) {
            $provinces->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $results = $provinces->get();
        return ApiResponse::success(ProvinceResource::collection($results), 'Get Provinces success.');
    }
    /**
     * get datatable resource for role access master.
     */
    public function provinceDatatable(Request $request)
    {

        $provinces = Province::query();

        return DataTables::eloquent($provinces)
            ->addColumn('action', function (Province $province) {
                $btn = view('datatables.locations.provinces.action', compact('province'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new province to database
     * 
     * @param  ProvinceRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ProvinceRequest $request)
    {
        $province = Province::create([
            'name' => $request->name,
        ]);
        toast('New province has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  ProvinceRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(ProvinceRequest $request, string $id)
    {
        $province = Province::find($id);

        $province->name = $request->name;
        $province->save();

        toast('Province has been updated', 'success');
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
        Province::destroy($id);
        toast('Province has been deleted', 'success');
        return back();
    }
}
