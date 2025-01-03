<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AccessCardQuery;
use App\Http\Resources\Api\AccessCardResource;
use App\Models\AccessCard;
use Illuminate\Http\Request;

class AccessCardController extends Controller
{
    /**
     * Get Access Card User.
     *
     * api for get access card user by unit from database
     *
     * @param  \App\Http\Requests\Api\AccessCardQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AccessCardQuery $request)
    {
        $limit = $request->limit ?? 10;
        $cards = AccessCard::with([
            'developer:id,name',
            'projectUnit:id,name'
        ])
            ->where('user_id', $request->user()->id);
        if ($request->developer_id) {
            $cards->where('developer_id', $request->developer_id);
        }
        if ($request->project_unit_id) {
            $cards->where('project_unit_id', $request->project_unit_id);
        }
        if ($request->search) {
            $cards->where('name', 'like', '%' . $request->search . '%');
        }
        $results = $cards->paginate($limit);
        return ApiResponse::success(AccessCardResource::collection($results), 'Get access card for units success.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Detail Access Card.
     * 
     * api for detail of access card from database
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $card = AccessCard::find($id);
        if (!$card) {
            return ApiResponse::success(null, 'Access card not found', 200);
        }
        return ApiResponse::success(new AccessCardResource($card), 'get detail Access Card user success');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * destroy access card.
     * 
     * api for user delete for access card
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $card = AccessCard::find($id);
        if (!$card) {
            return ApiResponse::error('Access Card not found', 404);
        }
        $card->delete();
        return ApiResponse::success(null, 'Delete access card user success', 204);
    }
}
