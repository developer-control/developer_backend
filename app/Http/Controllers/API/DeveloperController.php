<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeveloperQuery;
use App\Http\Resources\Api\DeveloperResource;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

    /**
     * Get Developers.
     * 
     * api for get developers data from database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DeveloperQuery $request)
    {
        $limit = $request->limit ?? 10;
        $developers = Developer::select('id', 'name');
        if ($request->search) {
            $developers->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $results = $developers->limit($limit)->get();
        return ApiResponse::success(DeveloperResource::collection($results), 'Get developers success.');
    }
}
