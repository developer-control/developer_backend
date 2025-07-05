<?php

namespace App\Http\Controllers\API\Posts;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PromotionQuery;
use App\Http\Resources\Api\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Get Promotions.
     * 
     * api for get promotion from database
     * 
     * @unauthenticated
     * @param  \App\Http\Requests\Api\PromotionQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PromotionQuery $request)
    {
        $limit = $request->limit ?? 10;
        $developer = $request->developer;
        $promotions = Promotion::with(['createdBy:id,name'])->where('is_active', 1);
        if ($request->search) {
            $promotions->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $promotions->where('developer_id', $developer->id);

        $results = $promotions->paginate($limit);
        return ApiResponse::success(PromotionResource::collection($results), 'Get promotions success.');
    }



    /**
     * Detail Promotions.
     * 
     * api for get detail promotion from database
     * 
     * @unauthenticated
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug, string $id)
    {
        $promotion = Promotion::with(['createdBy:id,name'])->find($id);
        if (!$promotion) {
            return ApiResponse::success(null, 'promotion not found', 200);
        }
        return ApiResponse::success(new PromotionResource($promotion), 'get detail promotion success');
    }
}
