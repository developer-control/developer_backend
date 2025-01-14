<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AccessCardQuery;
use App\Http\Requests\Api\AccessCardRequest;
use App\Http\Resources\Api\AccessCardResource;
use App\Models\AccessCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $results = $cards->latest()->paginate($limit);
        return ApiResponse::success(AccessCardResource::collection($results), 'Get access card for units success.');
    }


    /**
     * Store Access Card.
     * 
     * api for user generate access card
     *
     * @param  \App\Http\Requests\Api\AccessCardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AccessCardRequest $request)
    {
        DB::beginTransaction();
        $card = AccessCard::create([
            'user_id' => $request->user()->id,
            'developer_id' => $request->developer_id,
            'project_unit_id' => $request->project_unit_id,
            'name' => $request->name,
            'vehicle_number' => $request->vehicle_number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        DB::commit();
        return ApiResponse::success(new AccessCardResource($card), 'Create access card success', 201);
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
            return ApiResponse::error('Access Card not found', 404);
        }
        return ApiResponse::success(new AccessCardResource($card), 'get detail Access Card user success');
    }



    /**
     * Update access card.
     * 
     * api for user update request for complain
     *
     * @param  \App\Http\Requests\Api\AccessCardRequest   $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccessCardRequest $request, string $id)
    {
        $card = AccessCard::find($id);
        if (!$card) {
            return ApiResponse::error('Access card not found', 404);
        }
        DB::beginTransaction();
        $card->developer_id = $request->developer_id;
        $card->project_unit_id = $request->project_unit_id;
        $card->name = $request->name;
        $card->vehicle_number = $request->vehicle_number;
        $card->start_date = $request->start_date;
        $card->end_date = $request->end_date;
        $card->start_time = $request->start_time;
        $card->end_time = $request->end_time;
        $card->save();
        DB::commit();
        return ApiResponse::success(new AccessCardResource($card), 'Update access card succes', 200);
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
        return ApiResponse::success(null, 'Delete access card user success', 200);
    }
}
