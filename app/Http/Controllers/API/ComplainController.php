<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComplainQuery;
use App\Http\Requests\Api\ComplainRequest;
use App\Http\Resources\Api\ComplainResource;
use App\Models\Complain;
use App\Models\Media;
use App\Traits\UploadMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplainController extends Controller
{
    use UploadMedia;
    /**
     * Get Complain User.
     *
     * api for get unit from a project from database
     *
     * @param  \App\Http\Requests\Api\ComplainQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ComplainQuery $request)
    {
        $limit = $request->limit ?? 10;
        $complains = Complain::with([
            'developer:id,name',
            'project:id,name',
            'projectArea:id,name',
            'projectUnit:id,name',
            'solvedBy:id,name',
        ])
            ->where('user_id', $request->user()->id);
        if ($request->type) {
            $complains->where('type', $request->type); //unit, lingkungan, lainnya
        }
        if ($request->status) {
            $complains->where('status', $request->status); //request, finished
        }
        if ($request->search) {
            $complains->where('title', 'like', '%' . $request->search . '%');
        }
        $results = $complains->paginate($limit);
        return ApiResponse::success(ComplainResource::collection($results), 'Get project units success.');
    }
    /**
     * Store request complain.
     * 
     * api for user send request for complain
     *
     * @param  \App\Http\Requests\Api\ComplainRequest   $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ComplainRequest $request)
    {

        DB::beginTransaction();

        $images = @$request->images ?? [];

        $complain = Complain::create([
            'user_id' => $request->user()->id,
            'developer_id' => $request->developer_id,
            'project_id' => $request->project_id,
            'project_area_id' => $request->project_area_id,
            'project_unit_id' => $request->project_unit_id,
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description,
            'type' => $request->type,
            'images' => json_encode(@$images, true),
            'status' => 'request',
        ]);
        foreach (@$images  as $item) {
            $image_media = Media::where('url', $item)->first();
            if (@$image_media) {
                $complain->media()->attach($image_media, ['type' => 'image']);
            }
        }

        DB::commit();

        return ApiResponse::success(null, 'Create request complain succes', 201);
    }
    /**
     * Detail Comlain User.
     * 
     * api for detail of complain user from database
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $complain = Complain::find($id);
        if (!$complain) {
            return ApiResponse::success(null, 'complain not found', 200);
        }
        return ApiResponse::success(new ComplainResource($complain), 'get detail complain user success');
    }

    /**
     * Upload image file.
     * 
     * api to upload an image as proof of complain user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'complains/images', 600);

            if ($image) {
                Media::create([
                    'name' => "File image complain",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "File image complain",
                    'description' => null
                ]);
            }
        }
        $data = ['full_url' => storage_url($image), 'url' => $image];
        return ApiResponse::success($data, 'Upload image file complain user success.');
    }
    /**
     * Update request complain.
     * 
     * api for user update request for complain
     *
     * @param  \App\Http\Requests\Api\ComplainRequest   $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComplainRequest $request, int $id)
    {
        $complain = Complain::find($id);
        $oldImages = @json_decode($complain->images, true) ?? [];
        $images = @$request->images ?? [];
        if ($complain->status == 'finished') {
            return ApiResponse::error('The complaint request has been completed', 402);
        }
        DB::beginTransaction();
        $complain->developer_id = $request->developer_id;
        $complain->project_id = $request->project_id;
        $complain->project_area_id = $request->project_area_id;
        $complain->project_unit_id = $request->project_unit_id;
        $complain->title = $request->title;
        $complain->address = $request->address;
        $complain->description = $request->description;
        $complain->type = $request->type;

        $junk_images = array_diff($oldImages, $images);
        foreach ($junk_images as $item) {
            remove_file($item, $complain);
        }

        foreach (@$images as $item) {
            $media = Media::where('url', $item)->first();
            if (@$media) {
                $complain->media()->syncWithoutDetaching([$media->id => ['type' => 'image']]);
            }
        }
        $complain->images = json_encode(@$images, true);
        $complain->save();
        DB::commit();
        return ApiResponse::success(null, 'Update request complain succes', 200);
    }

    /**
     * destroy complain.
     * 
     * api for user delete for complain
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $complain = Complain::find($id);
        if (!$complain) {
            return ApiResponse::error('Complain not found', 404);
        }
        $images = @json_decode($complain->images, true) ?? [];
        foreach ($images as $item) {
            remove_file($item, $complain);
        }
        $complain->delete();
        return ApiResponse::success(null, 'Delete complain user success', 204);
    }
}
