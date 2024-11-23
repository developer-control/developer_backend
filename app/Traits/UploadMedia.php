<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait UploadMedia
{
    public function uploadImage(Request $request, $folder, $width_size = 720): ?string
    {
        // dd($request);
        try {
            $path = @$request->file('image')->hashName($folder);

            $img = ImageManager::gd()->read(@$request->file('image'));
            $img->scale(width: $width_size);

            Storage::put($path, (string) $img->encode());
            $path_image = $path;

            return $path_image;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
