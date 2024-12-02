<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectBlocQuery;
use App\Http\Resources\Api\BlocResource;
use App\Models\ProjectBloc;
use Illuminate\Http\Request;

class BlocController extends Controller
{
    /**
     * Get Project bloc.
     * 
     * api for get bloc for a area project from database
     *
     * @param  \App\Http\Requests\Api\ProjectBlocQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectBlocQuery $request)
    {
        $limit = $request->limit ?? 10;
        $areas = ProjectBloc::select('id', 'name');
        if ($request->search) {
            $areas->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->project_area_id) {
            $areas->where('project_area_id', $request->project_area_id);
        }
        $results = $areas->limit($limit)->get();
        return ApiResponse::success(BlocResource::collection($results), 'Get project blocs success.');
    }
}
