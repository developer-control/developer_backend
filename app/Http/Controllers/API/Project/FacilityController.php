<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FacilityQuery;
use App\Http\Resources\Api\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Get Facilities.
     * 
     * api for get facilities from database
     * 
     * 
     * @param  \App\Http\Requests\Api\FacilityQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FacilityQuery $request)
    {
        $limit = $request->limit ?? 10;
        $developer = $request->developer;
        $facilities = Facility::with(['createdBy:id,name', 'project:id,name,city_id,developer_id', 'developer:id,name'])
            ->where('developer_id', $developer->id);
        if ($request->search) {
            $facilities->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->project_id) {
            $facilities->where('project_id', $request->project_id);
        }
        $results = $facilities->paginate($limit);
        return ApiResponse::success(FacilityResource::collection($results), 'Get facilities success.');
    }



    /**
     * Detail Facility.
     * 
     * api for get detail facility from database
     * 
     * 
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $slug, string $id)
    {
        $developer = $request->developer;
        $facility = Facility::with(['createdBy:id,name', 'project:id,name,city_id,developer_id', 'developer:id,name'])
            ->where('developer_id', $developer->id)
            ->find($id);
        if (!$facility) {
            return ApiResponse::success(null, 'facility not found', 200);
        }
        return ApiResponse::success(new FacilityResource($facility), 'get detail facility success');
    }
}
