<?php

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
            url('/') . "/assets/main/images/default-secondary.png";
    }
}
