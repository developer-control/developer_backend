<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LocationQuery;
use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\ProvinceResource;
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
     * @param  \App\Http\Requests\Api\LocationQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexProvince(LocationQuery $request)
    {
        $limit = $request->limit ?? 10;
        $provinces = Province::select('id', 'name');
        if ($request->search) {
            $provinces->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $results = $provinces->limit($limit)->get();
        return ApiResponse::success(ProvinceResource::collection($results), 'Get Provinces success.');
    }

    /**
     * Get City.
     * 
     * api for get city data from database
     *
     * @unauthenticated 
     * @param  \App\Http\Requests\Api\LocationQuery $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexCity(LocationQuery $request)
    {
        $limit = $request->limit ?? 10;
        $cities = City::select('id', 'province_id', 'name');
        if ($request->search) {
            $cities->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $results = $cities->limit($limit)->get();
        return ApiResponse::success(CityResource::collection($results), 'Get Cities success.');
    }
}
