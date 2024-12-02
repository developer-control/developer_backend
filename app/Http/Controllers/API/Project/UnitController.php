<?php

namespace App\Http\Controllers\API\Project;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectUnitQuery;
use App\Http\Requests\Api\UserUnitQuery;
use App\Http\Resources\Api\UnitResource;
use App\Http\Resources\UserUnitResource;
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
     * Get Project areas.
     * 
     * api for get area for a project from database
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
     * Upload evidence file.
     * 
     * api to upload an image as proof of unit ownership
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function UploadEvidenceFile(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'ownership-units/evidence', 600);

            if ($image) {
                Media::create([
                    'name' => "File Evidence Unit",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "File Evidence Unit",
                    'description' => null
                ]);
            }
        }
        $data = ['full_url' => storage_url($image), 'url' => $image];
        return ApiResponse::success($data, 'Upload evidence file ownership success.');
    }

    /**
     * Store request claim unit.
     * 
     * api for user send request for claim unit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeClaimUnit(Request $request)
    {
        $request->validate([
            'developer_id' => 'required',
            'project_id' => 'required',
            'project_area_id' => 'required',
            'project_bloc_id' => 'required',
            'project_unit_id' => 'required',
            'ownership_unit_id' => 'required',
            'city_id' => 'required'
        ]);
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
        $evidence_file = Media::where('url', $request->evidence_file)->first();
        if ($evidence_file) {
            $unit->media()->attach($evidence_file, ['type' => 'image']);
        }
        DB::commit();

        return ApiResponse::success(null, 'Create request claim unit succes', 201);
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
            ->where('user_units.is_active', 1)
            ->where('user_units.status', 'claimed');

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
        if ($request->limit) {
            $units->limit($request->limit);
        }
        $results = $units->get();
        return ApiResponse::success(UserUnitResource::collection($results), 'Get project units success.');
    }
}
