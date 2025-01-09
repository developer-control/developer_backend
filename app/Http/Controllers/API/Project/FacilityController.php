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
        $facilities = Facility::with(['createdBy:id,name', 'project:id,name', 'developer:id,name']);
        if ($request->search) {
            $facilities->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->developer_id) {
            $facilities->where('developer_id', $request->developer_id);
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
    public function show(string $id)
    {
        $facility = Facility::with(['createdBy:id,name', 'project:id,name', 'developer:id,name'])->find($id);
        if (!$facility) {
            return ApiResponse::success(null, 'facility not found', 200);
        }
        return ApiResponse::success(new FacilityResource($facility), 'get detail facility success');
    }
}
