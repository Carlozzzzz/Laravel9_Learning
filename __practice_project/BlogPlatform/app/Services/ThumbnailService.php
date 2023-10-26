<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class ThumbnailService
{

    public static function createThumbnail($path, $width, $height) 
    {
        $img = Image::make($path)->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}