<?php

namespace App\Http\Controllers\Base;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Traits\UploadMedia;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use UploadMedia;
    public function storeArticleImage(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'articles/contents', 600);

            if ($image) {
                Media::create([
                    'name' => "Article Contents",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "Article Contents",
                    'description' => null
                ]);
            }
        }

        return response()->json(['url' => storage_url($image), 'path' => $image]);
    }

    public function storePromotionImage(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'promotions/contents', 600);

            if ($image) {
                Media::create([
                    'name' => "Promotion Contents",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "Promotion Contents",
                    'description' => null
                ]);
            }
        }

        return response()->json(['url' => storage_url($image), 'path' => $image]);
    }
    public function storeBannerImage(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'banners/contents', 600);

            if ($image) {
                Media::create([
                    'name' => "Banner Contents",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "Banner Contents",
                    'description' => null
                ]);
            }
        }

        return response()->json(['url' => storage_url($image), 'path' => $image]);
    }
    /**
     * Upload image file.
     * 
     * api to upload an image to database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            /**
             * type
             * 
             * @example complains, evidences
             */
            'type' => ['string', 'required']
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'contents/images', 600);

            if ($image) {
                Media::create([
                    'name' => "File image " . @$request->type,
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "File image " . @$request->type,
                    'description' => null
                ]);
            }
        }
        $data = ['full_url' => storage_url($image), 'url' => $image];
        return ApiResponse::success($data, 'Upload image file success.');
    }
}
