<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClaimUnitRequest;
use App\Http\Requests\Api\HistoryUserUnitQuery;
use App\Http\Requests\Api\ProjectUnitQuery;
use App\Http\Requests\Api\UserUnitQuery;
use App\Http\Resources\Api\UnitResource;
use App\Http\Resources\Api\UserUnitResource;
use App\Models\Media;
use App\Models\ProjectUnit;
use App\Models\UserUnit;
use App\Traits\UploadMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    use UploadMedia;
    /**
     * Get Project unit.
     * 
     * api for get unit from a project from database
     *
     * @param  \App\Http\Requests\Api\ProjectUnitQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectUnitQuery $request)
    {
        $limit = $request->limit ?? 10;
        $areas = ProjectUnit::select('id', 'name');
        if ($request->search) {
            $areas->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->project_bloc_id) {
            $areas->where('project_bloc_id', $request->project_bloc_id);
        }
        $results = $areas->limit($limit)->get();
        return ApiResponse::success(UnitResource::collection($results), 'Get project units success.');
    }


    /**
     * Store request claim unit.
     * 
     * api for user send request for claim unit
     *
     * @param  \App\Http\Requests\Api\ClaimUnitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeClaimUnit(ClaimUnitRequest $request)
    {

        DB::beginTransaction();
        $unit = UserUnit::create([
            'developer_id' => $request->developer_id,
            'project_id' => $request->project_id,
            'project_area_id' => $request->project_area_id,
            'project_bloc_id' => $request->project_bloc_id,
            'project_unit_id' => $request->project_unit_id,
            'city_id' => $request->city_id,
            'user_id' => $request->user()->id,
            'ownership_unit_id' => $request->ownership_unit_id,
            'status' => 'request',
            'is_active' => 0,
        ]);
        //get media
        $evidence_file = Media::where('url', path_image($request->evidence_file))->first();
        if ($evidence_file) {
            $unit->media()->attach($evidence_file, ['type' => 'image']);
            $unit->evidence_file = $evidence_file->url;
            $unit->save();
        }
        DB::commit();

        return ApiResponse::success(null, 'Create request claim unit success', 201);
    }


    /**
     * Get unit user.
     * 
     * api for get unit user from database
     *
     *  
     * @param  \App\Http\Requests\Api\UserUnitQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexMyUnit(UserUnitQuery $request)
    {
        $limit = $request->limit ?? 10;
        $units = UserUnit::select(
            'user_units.*',
            'developers.name as developer_name',
            'projects.name as project_name',
            'project_areas.name as area_name',
            'project_blocs.name as bloc_name',
            'project_units.name as unit_name',
            'cities.name as city_name',
            'ownership_units.name as ownership_unit_name'
        )
            ->join('developers', 'user_units.developer_id', '=', 'developers.id')
            ->join('projects', 'user_units.project_id', '=', 'projects.id')
            ->join('project_areas', 'user_units.project_area_id', '=', 'project_areas.id')
            ->join('project_blocs', 'user_units.project_bloc_id', '=', 'project_blocs.id')
            ->join('project_units', 'user_units.project_unit_id', '=', 'project_units.id')
            ->join('cities', 'user_units.city_id', '=', 'cities.id')
            ->join('ownership_units', 'user_units.ownership_unit_id', '=', 'ownership_units.id')
            ->where('user_units.user_id', $request->user()->id);
        if ($request->status) {
            $units->where('user_units.status', $request->status);
            if ($request->status == 'claimed' && $request->is_active) {
                $units->where('user_units.is_active', $request->is_active ? 1 : 0);
            }
        }
        if ($request->search) {
            $search = '%' . $request->search . '%';
            $units->where(function ($query) use ($search) {
                $query->where('developers.name', 'like', $search)
                    ->orWhere('projects.name', 'like', $search)
                    ->orWhere('project_areas.name', 'like', $search)
                    ->orWhere('project_blocs.name', 'like', $search)
                    ->orWhere('project_units.name', 'like', $search)
                    ->orWhere('cities.name', 'like', $search);
            });
        }

        $results = $units->paginate($limit);
        return ApiResponse::success(UserUnitResource::collection($results), 'Get project units success.');
    }
    /**
     * Get History unit user.
     * 
     * api for get history unit user if non active from database
     *
     *  
     * @param  \App\Http\Requests\Api\HistoryUserUnitQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexHistoryMyUnit(HistoryUserUnitQuery $request)
    {
        $limit = $request->limit ?? 10;
        $units = UserUnit::select(
            'user_units.*',
            'developers.name as developer_name',
            'projects.name as project_name',
            'project_areas.name as area_name',
            'project_blocs.name as bloc_name',
            'project_units.name as unit_name',
            'cities.name as city_name',
            'ownership_units.name as ownership_unit_name'
        )
            ->join('developers', 'user_units.developer_id', '=', 'developers.id')
            ->join('projects', 'user_units.project_id', '=', 'projects.id')
            ->join('project_areas', 'user_units.project_area_id', '=', 'project_areas.id')
            ->join('project_blocs', 'user_units.project_bloc_id', '=', 'project_blocs.id')
            ->join('project_units', 'user_units.project_unit_id', '=', 'project_units.id')
            ->join('cities', 'user_units.city_id', '=', 'cities.id')
            ->join('ownership_units', 'user_units.ownership_unit_id', '=', 'ownership_units.id')
            ->where('user_units.user_id', $request->user()->id)
            ->where('user_units.is_active', 0);
        if ($request->status) {
            $units->where('user_units.status', $request->status);
        }
        if ($request->search) {
            $search = '%' . $request->search . '%';
            $units->where(function ($query) use ($search) {
                $query->where('developers.name', 'like', $search)
                    ->orWhere('projects.name', 'like', $search)
                    ->orWhere('project_areas.name', 'like', $search)
                    ->orWhere('project_blocs.name', 'like', $search)
                    ->orWhere('project_units.name', 'like', $search)
                    ->orWhere('cities.name', 'like', $search);
            });
        }

        $results = $units->paginate($limit);
        return ApiResponse::success(UserUnitResource::collection($results), 'Get project units success.');
    }
    /**
     * Detail Unit User.
     * 
     * api for detail of unit user from database
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUnitUser(int $id)
    {
        $unit = UserUnit::select(
            'user_units.*',
            'developers.name as developer_name',
            'projects.name as project_name',
            'project_areas.name as area_name',
            'project_blocs.name as bloc_name',
            'project_units.name as unit_name',
            'cities.name as city_name',
            'ownership_units.name as ownership_unit_name'
        )
            ->join('developers', 'user_units.developer_id', '=', 'developers.id')
            ->join('projects', 'user_units.project_id', '=', 'projects.id')
            ->join('project_areas', 'user_units.project_area_id', '=', 'project_areas.id')
            ->join('project_blocs', 'user_units.project_bloc_id', '=', 'project_blocs.id')
            ->join('project_units', 'user_units.project_unit_id', '=', 'project_units.id')
            ->join('cities', 'user_units.city_id', '=', 'cities.id')
            ->join('ownership_units', 'user_units.ownership_unit_id', '=', 'ownership_units.id')
            ->where('user_units.id', $id)
            ->first();
        if (!$unit) {
            return ApiResponse::success(null, 'unit not found', 200);
        }
        return ApiResponse::success(new UserUnitResource($unit), 'get detail unit user success');
    }
}
