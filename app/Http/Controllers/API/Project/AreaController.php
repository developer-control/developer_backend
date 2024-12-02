<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectAreaQuery;
use App\Http\Resources\Api\AreaResource;
use App\Models\ProjectArea;

class AreaController extends Controller
{
    /**
     * Get Project areas.
     * 
     * api for get area for a project from database
     *
     * @param  \App\Http\Requests\Api\ProjectAreaQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectAreaQuery $request)
    {
        $limit = $request->limit ?? 10;
        $areas = ProjectArea::select('id', 'name');
        if ($request->search) {
            $areas->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->project_id) {
            $areas->where('project_id', $request->project_id);
        }
        $results = $areas->limit($limit)->get();
        return ApiResponse::success(AreaResource::collection($results), 'Get project areas success.');
    }
}
