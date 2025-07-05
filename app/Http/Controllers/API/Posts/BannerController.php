<?php

namespace App\Http\Controllers\API\Posts;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BannerQuery;
use App\Http\Resources\Api\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Get Banners.
     * 
     * api for get banner from database
     * 
     * @unauthenticated
     * @param  \App\Http\Requests\Api\BannerQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BannerQuery $request)
    {
        $limit = $request->limit ?? 10;
        $developer = $request->developer;
        $banners = Banner::with(['createdBy:id,name'])->where('is_active', 1);
        if ($request->search) {
            $banners->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $banners->where('developer_id', $developer->id);

        $results = $banners->paginate($limit);
        return ApiResponse::success(BannerResource::collection($results), 'Get banners success.');
    }



    /**
     * Detail Banner.
     * 
     * api for get detail banner from database
     * 
     * @unauthenticated
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug, string $id)
    {
        $banner = Banner::with(['createdBy:id,name'])->find($id);
        if (!$banner) {
            return ApiResponse::success(null, 'banner not found', 200);
        }
        return ApiResponse::success(new BannerResource($banner), 'get detail banner success');
    }
}
