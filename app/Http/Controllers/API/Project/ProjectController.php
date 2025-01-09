<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectQuery;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Get Project Developer.
     * 
     * api for get project form developers data from database
     *
     * @param  \App\Http\Requests\Api\ProjectQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectQuery $request)
    {
        $limit = $request->limit ?? 10;
        $projects = Project::with(['city:id,name'])->select('id', 'name');
        if ($request->search) {
            $projects->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->developer_id) {
            $projects->where('developer_id', $request->developer_id);
        }
        if ($request->city_id) {
            $projects->where('city_id', $request->city_id);
        }
        $results = $projects->limit($limit)->get();
        return ApiResponse::success(ProjectResource::collection($results), 'Get projects success.');
    }
}
