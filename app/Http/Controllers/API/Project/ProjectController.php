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
        $developer = $request->developer;
        $limit = $request->limit ?? 10;
        $projects = Project::with(['city:id,name', 'developer:id,name'])
            ->select('id', 'name', 'city_id', 'developer_id')
            ->where('developer_id', $developer->id);
        if ($request->search) {
            $projects->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->city_id) {
            $projects->where('city_id', $request->city_id);
        }
        $results = $projects->limit($limit)->get();
        return ApiResponse::success(ProjectResource::collection($results), 'Get projects success.');
    }
}
