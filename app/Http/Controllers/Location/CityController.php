<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage city']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.locations.city');
    }

    public function initializeCity()
    {

        DB::beginTransaction();
        $provinces = Province::all();
        foreach ($provinces as $province) {
            $response = Http::get("https://wilayah.id/api/regencies/{$province->id}.json");
            // return $response->object()->data;
            foreach (@$response->object()->data ?? [] as $city) {
                // dd($city->code);
                $id = str_replace('.', '', $city->code);
                if (!City::where('id', $id)->exists()) {
                    // Jika email tidak ada, maka insert data
                    City::create([
                        'id' => $id,
                        'province_id' => $province->id,
                        'name' => $city->name
                    ]);
                }
            }
        }
        DB::commit();
        toast('Initialize City Success', 'success');
        return back();
    }
    /**
     * get datatable resource for role access master.
     */
    public function cityDatatable(Request $request)
    {

        $cities = City::with(['province'])->select('cities.*');

        return DataTables::eloquent($cities)
            ->editColumn('province.name', function (City $city) {
                return @$city->province->name;
            })
            ->addColumn('action', function (City $city) {
                $btn = view('datatables.locations.cities.action', compact('city'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new city to database
     * 
     * @param  CityRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(CityRequest $request)
    {
        City::create([
            'province_id' => $request->province_id,
            'name' => $request->name,
        ]);
        toast('New city has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  CityRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(CityRequest $request, string $id)
    {
        $city = City::find($id);

        $city->province_id = $request->province_id;
        $city->name = $request->name;
        $city->save();

        toast('City has been updated', 'success');
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
        City::destroy($id);
        toast('City has been deleted', 'success');
        return back();
    }
}
