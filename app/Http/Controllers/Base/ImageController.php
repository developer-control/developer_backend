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
    public function storeFacilityImage(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'facilities/contents', 600);

            if ($image) {
                Media::create([
                    'name' => "Facility Contents",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "Facility Contents",
                    'description' => null
                ]);
            }
        }

        return response()->json(['url' => storage_url($image), 'path' => $image]);
    }

    public function storeBankDeveloperImage(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request, 'developer-banks/contents', 600);

            if ($image) {
                Media::create([
                    'name' => "Developer Bank",
                    'type' => @$request->image->getMimeType(),
                    'url' => $image,
                    'alt' => null,
                    'title' => "Developer Bank",
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
            $image = $this->uploadImage($request, 'contents/images', 720);

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


    /**
     * Upload file to database meda storage.
     * 
     * api to upload an file to database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            /**
             * type
             * 
             * @example complains, evidences
             */
            'type' => ['string', 'required']
        ]);
        $file = null;
        if ($request->hasFile('file')) {
            $option = [
                // 'disk' => diskAWS(),
                'ContentType' => $request->file('file')->getClientMimeType(),
            ];
            $file = @$request->file('file')->store('contents/file', $option);
            if ($file) {
                Media::create([
                    'name' => "File " . @$request->type,
                    'type' => @$request->file->getMimeType(),
                    'url' => $file,
                    'alt' => null,
                    'title' => "File " . @$request->type,
                    'description' => null
                ]);
            }
        }
        $data = ['full_url' => storage_url($file), 'url' => $file];
        return ApiResponse::success($data, 'Upload file success.');
    }

    public function storeIdentiyUser(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:6144',
        ]);
        if ($request->hasFile('image')) {
            // Simpan file di storage
            $file = $request->file('image');
            $fileMimeType = $file->getMimeType();

            if (strpos($fileMimeType, 'image') !== false) {
                $filePath = $this->uploadImage($request, 'users/identities', 720);
            } else {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $header = [
                    'ContentType' => $fileMimeType,
                    'disk' => 'public',
                ];
                $filePath = $file->storeAs('users/identities', $fileName, $header);
            }
            if ($filePath) {
                Media::create([
                    'name' => "User Identity",
                    'type' => $fileMimeType,
                    'url' => $filePath,
                    'alt' => null,
                    'title' => "User Identity",
                    'description' => null
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully.',
                'filePath' => $filePath,
                'url' => storage_url($filePath)
                // 'fileName' => $fileName,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.',
        ]);
    }
}
