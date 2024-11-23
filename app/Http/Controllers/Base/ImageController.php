<?php

namespace App\Http\Controllers\Base;

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
}
