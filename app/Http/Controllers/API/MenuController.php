<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DeveloperResource;
use App\Models\Developer;
use App\Models\Feature;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Get List Menu
     *
     * api for get total bill from unit 
     *
     * @param  string  $developer_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $developer = $request->developer;
        $features = Feature::where('group', 'api')->get();
        $data = [];
        foreach ($features as $feature) {
            $canAccess = $feature->developers()
                ->where('id', $developer->id)
                ->exists() ? 1 : 0;
            $data[] = [
                'id' => (int) $feature->id,
                'key' => $feature->key,
                'name' => $feature->name,
                'developer' => new DeveloperResource($developer),
                'has_access' => (int) $canAccess,
            ];
        }
        return ApiResponse::success($data, 'Get menu access developer success.');
    }
}
