<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SupportResource;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Get Support.
     * 
     * api for get support data from database
     * @unauthenticated 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'string|nullable',
            'limit' => 'string|nullable'
        ]);
        $developer = $request->developer;
        $supports = Support::with(['developer:id,name'])->select('id', 'title', 'value', 'type', 'developer_id')->where('developer_id', $developer->id);
        if ($request->search) {
            $supports->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->limit) {
            $supports->limit($request->limit);
        }
        $results = $supports->get();
        return ApiResponse::success(SupportResource::collection($results), 'Get supports success.');
    }
    /**
     * Detail support.
     * 
     * api for detail of unit user from database
     * @unauthenticated 
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $support = Support::with(['developer:id,name'])->select('id', 'title', 'value', 'type', 'developer_id')
            ->where('id', $id)
            ->first();
        if (!$support) {
            return ApiResponse::success(null, 'support not found', 200);
        }
        return ApiResponse::success(new SupportResource($support), 'get detail support user success');
    }
}
