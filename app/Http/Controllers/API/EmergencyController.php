<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EmergencyResource;
use App\Models\EmergencyNumber;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    /**
     * Get Emergency Number from project.
     * 
     * api for get emergency namber for a project from database
     *
     * @param  \use Illuminate\Http\Request;  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'required|int',
            'search' => 'string|nullable',
            'limit' => 'int|nullable'
        ]);
        $developer = $request->developer;
        $areas = EmergencyNumber::with(['project'])->where('developer_id', $developer->id);
        if ($request->search) {
            $areas->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->project_id) {
            $areas->where('project_id', $request->project_id);
        }
        if ($request->limit) {
            $areas->limit($request->limit);
        }
        $results = $areas->get();
        return ApiResponse::success(EmergencyResource::collection($results), 'Get emergency numbers success.');
    }
}
