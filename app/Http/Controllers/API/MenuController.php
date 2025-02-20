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
    public function index($developer_id)
    {
        $hasAccess = Feature::where('group', 'api')
            ->where(function ($q) use ($developer_id) {
                $q->whereHas('subscriptions.developerSubscriptions', function ($q) use ($developer_id) {
                    $q->where('developer_id', $developer_id);
                })
                    ->orWhere('type', 'free');
            })->pluck('id')->all();
        $features = Feature::where('group', 'api')->get();
        $developer = Developer::find($developer_id);
        $data = [];
        foreach ($features as $feature) {
            $canAccess = in_array($feature->id, $hasAccess) ? 1 : 0;
            $data[] = [
                'id' => $feature->id,
                'key' => $feature->key,
                'name' => $feature->name,
                'developer' => new DeveloperResource($developer),
                'has_access' => $canAccess,
            ];
        }
        return ApiResponse::success($data, 'Get menu access developer success.');
    }
}
