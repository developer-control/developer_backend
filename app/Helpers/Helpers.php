<?php

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

/**
 * @method static \Illuminate\Contracts\Filesystem\Filesystem disk(string|null $name = null)
 * @method string url(string $path)
 */
if (!function_exists('storage_url')) {
    function storage_url($path, $fullPath = '', $defaultImage = null)
    {
        if ($path) {
            if (Storage::disk('public')->exists(@$path)) {
                return asset('storage/' . @$path);
            }
            // if (Storage::disk('s3')->exists(@$path)) {
            //     return Storage::disk('s3')->url(@$path);
            // }

        }

        $sourcePath = public_path($fullPath);
        if (file_exists($sourcePath) && is_file($sourcePath)) {
            return url('/') . '/' . $fullPath;
        }


        return @$defaultImage ??
            url('/') . "/assets/images/default-image.jpg";
    }
}
if (!function_exists('remove_file')) {
    function remove_file($path, $sourceable = null)
    {
        try {
            if (Storage::exists(@$path)) {
                Storage::delete(@$path);
            }
            if (Storage::disk('public')->exists(@$path)) {
                Storage::disk('public')->delete(@$path);
            }

            // if (Storage::disk('s3')->exists(@$path)) {
            //     Storage::disk('s3')->delete(@$path);
            // }
        } catch (\Throwable $th) {
        }
        if ($sourceable) {
            $media =  Media::withTrashed()->where('url', $path)->first();
            @$sourceable->media()->detach($media->id);
        }
        Media::where('url', $path)->delete();
    }
}
if (!function_exists('path_image')) {
    function path_image($fullUrl)
    {
        return strstr($fullUrl, 'contents');
    }
}
