<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get Province.
     * 
     * api for get province data from database
     *
     * @unauthenticated 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexProvince(Request $request)
    {
        // $limit = $request->limit ?? 10;
        $provinces = Province::select('id', 'name');
        if ($request->search) {
            $provinces->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->limit) {
            $provinces->limit($request->limit);
        }
        $results = $provinces->get();
        return ApiResponse::success($results, 'Get Provinces success.');
    }

    /**
     * Get City.
     * 
     * api for get city data from database
     *
     * @unauthenticated 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexCity(Request $request)
    {
        // $limit = $request->limit ?? 10;
        $cities = City::select('id', 'name');
        if ($request->search) {
            $cities->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->limit) {
            $cities->limit($request->limit);
        }
        $results = $cities->get();
        return ApiResponse::success($results, 'Get Cities success.');
    }
}
