<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OwnershipUnitResource;
use App\Models\OwnershipUnit;
use Illuminate\Http\Request;

class OwnershipUnitController extends Controller
{

    /**
     * Get Ownership Units.
     * 
     * api for get list option for ownership unit from database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ownerships = OwnershipUnit::select('id', 'name');
        $results = $ownerships->get();
        return ApiResponse::success(OwnershipUnitResource::collection($results), 'Get ownership unit success.');
    }
}
