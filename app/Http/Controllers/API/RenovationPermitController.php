<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RenovationPermitRequest;
use App\Http\Resources\Api\RenovationPermitResource;
use App\Models\Media;
use App\Models\ProjectUnit;
use App\Models\RenovationPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenovationPermitController extends Controller
{
    /**
     * Get renovation permit.
     *
     * api for get renovation permit unit from database
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $unit_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, string $unit_id)
    {
        $request->validate([
            'project_id' => 'int|required',
            'search' => 'string|nullable',
            'limit' => 'int|nullable',
            /**
             * Page number
             * 
             * @example 1
             */
            'page' => 'int|nullable',
            /**
             * Status
             * 
             * @example request,reject,approved
             */
            'status' => 'string|nullable',
        ]);
        $limit = $request->limit ?? 10;
        $permits = RenovationPermit::where('project_unit_id', $unit_id);
        if ($request->status) {
            $permits->where('status', $request->status);
        }
        $results = $permits->latest()->paginate($limit);
        return ApiResponse::success(RenovationPermitResource::collection($results), 'Get renovation permits success.');
    }


    /**
     * Store renovation permit.
     *
     * api for store renovation permit unit from database
     *
     * @param \App\Http\Requests\Api\RenovationPermitRequest $request
     * @param  string $unit_id
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(RenovationPermitRequest $request, string $unit_id)
    {
        $unit = ProjectUnit::find($unit_id);
        if (!$unit) {
            return ApiResponse::error('Unit Not Found', 404);
        }
        try {
            DB::beginTransaction();
            $request->merge([
                'user_id' => $request->user()->id,
                'developer_id' => $unit->developer_id,
                'id_card_photo' => $request->id_card_photo ? path_image($request->id_card_photo) : null,
                'unit_layout' => $request->unit_layout ? path_image($request->unit_layout) : null,
                'neighborhood_certificate' => $request->neighborhood_certificate ? path_image($request->neighborhood_certificate) : null,
                'power_of_attorney' => $request->power_of_attorney ? path_image($request->power_of_attorney) : null,
                'permit_letter' => $request->permit_letter ? path_image($request->permit_letter) : null,
                'deposit_statement' => $request->deposit_statement ? path_image($request->deposit_statement) : null,
                'neighbor_information' => $request->neighbor_information ? path_image($request->neighbor_information) : null,
                'status' => 'request'
            ]);
            $permit = $unit->renovationPermits()->create($request->all());
            $this->setMedia($request, null, $permit);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error($th->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Create renovation permit success', 201);
    }

    public function syncMedia($path, $old_path, $permit)
    {
        if ($old_path != $path) {
            if ($old_path) {
                remove_file($old_path, $permit);
            }
            $file = Media::where('url', $path)->first();
            if ($file) {
                $permit->media()->attach($file, ['type' => 'file']);
            }
        }
    }

    public function setMedia($request, $permit, $oldPermit)
    {
        if ($request->id_card_photo) {
            $this->syncMedia($request->id_card_photo, @$oldPermit->id_card_photo, $permit);
        }
        if ($request->unit_layout) {
            $this->syncMedia($request->unit_layout, @$oldPermit->unit_layout, $permit);
        }
        if ($request->neighborhood_certificate) {
            $this->syncMedia($request->neighborhood_certificate, @$oldPermit->neighborhood_certificate, $permit);
        }
        if ($request->power_of_attorney) {
            $this->syncMedia($request->power_of_attorney, @$oldPermit->power_of_attorney, $permit);
        }
        if ($request->permit_letter) {
            $this->syncMedia($request->permit_letter, @$oldPermit->permit_letter, $permit);
        }
        if ($request->deposit_statement) {
            $this->syncMedia($request->deposit_statement, @$oldPermit->deposit_statement, $permit);
        }
        if ($request->neighbor_information) {
            $this->syncMedia($request->neighbor_information, @$oldPermit->neighbor_information, $permit);
        }
    }

    /**
     * Detail renovation permit.
     *
     * api for get detail renovation permit unit from database
     *
     * @param string $unit_id
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $unit_id, string $id)
    {
        $unit = ProjectUnit::find($unit_id);
        if (!$unit) {
            return ApiResponse::error('Unit Not Found', 404);
        }
        $permit = RenovationPermit::find($id);

        if (!$permit) {
            return ApiResponse::error('Renovation permit not found', 404);
        }
        return ApiResponse::success(new RenovationPermitResource($permit), 'get detail renovation permit success');
    }

    /**
     * Update renovation permit.
     *
     * api for update renovation permit unit from database
     *
     * @param \App\Http\Requests\Api\RenovationPermitRequest $request
     * @param  string $unit_id
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RenovationPermitRequest $request, string $unit_id, string $id)
    {
        $unit = ProjectUnit::find($unit_id);
        if (!$unit) {
            return ApiResponse::error('Unit Not Found', 404);
        }

        $permit = RenovationPermit::find($id);
        if (!$permit) {
            return ApiResponse::error('Renovation permit not found', 404);
        }
        if ($permit->status != 'request') {
            return ApiResponse::error('Renovation permit not request', 400);
        }
        try {
            DB::beginTransaction();
            $request->merge([
                'id_card_photo' => $request->id_card_photo ? path_image($request->id_card_photo) : null,
                'unit_layout' => $request->unit_layout ? path_image($request->unit_layout) : null,
                'neighborhood_certificate' => $request->neighborhood_certificate ? path_image($request->neighborhood_certificate) : null,
                'power_of_attorney' => $request->power_of_attorney ? path_image($request->power_of_attorney) : null,
                'permit_letter' => $request->permit_letter ? path_image($request->permit_letter) : null,
                'deposit_statement' => $request->deposit_statement ? path_image($request->deposit_statement) : null,
                'neighbor_information' => $request->neighbor_information ? path_image($request->neighbor_information) : null,
            ]);
            $this->setMedia($request, $permit, $permit);
            $permit->update($request->all());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error($th->getMessage(), 500);
        }
    }

    /**
     * Delete renovation permit.
     *
     * api for destroy renovation permit unit from database
     *
     * @param  string $unit_id
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $unit_id, string $id)
    {
        $unit = ProjectUnit::find($unit_id);
        if (!$unit) {
            return ApiResponse::error('Unit Not Found', 404);
        }
        $permit = RenovationPermit::find($id);
        if (!$permit) {
            return ApiResponse::error('Renovation permit not found', 404);
        }

        if ($permit->id_card_photo) {
            remove_file($permit->id_card_photo, $permit);
        }
        if ($permit->unit_layout) {
            remove_file($permit->unit_layout, $permit);
        }
        if ($permit->neighborhood_certificate) {
            remove_file($permit->neighborhood_certificate, $permit);
        }
        if ($permit->power_of_attorney) {
            remove_file($permit->power_of_attorney, $permit);
        }
        if ($permit->permit_letter) {
            remove_file($permit->permit_letter, $permit);
        }
        if ($permit->deposit_statement) {
            remove_file($permit->deposit_statement, $permit);
        }
        if ($permit->neighbor_information) {
            remove_file($permit->neighbor_information, $permit);
        }
        $permit->delete();
        return ApiResponse::success(null, 'Delete renovation permit user success', 200);
    }
    public function inputNotFile()
    {
        return  ['id', 'user_id', 'project_unit_id', 'developer_id', 'title', 'status', 'notes', 'created_at', 'updated_at'];
    }
}
