<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageLinkService
{
    protected $defaultProfileImgLink            = "https://api.dicebear.com/avatar.svg";
    protected $defaultCoverImgLink              = "storage/default-img.png";
    protected $defaultPostImgLink               = "storage/default-img.png";
    protected $defaultUnavailableImgLink        = "storage/unavailable-image.jpg";

    public function imageStorageLocation($filename = "", $imageType = "", $isThumbnail  = false)
    {
        $imageLocation = "";
        if( $filename ) {
            $imageLocation = $this->getImageLocation($filename, $imageType, $isThumbnail);
        } else {
            $imageLocation = $this->getDefaultImageLocation($imageType);
        }
        return $imageLocation;
    }

   
    function getImageLocation($filename, $imageType, $isThumbnail = false)
    {
        $result = "";

        $thumbnailPath = $isThumbnail ? "thumbnail/" : "";

        if (str_contains($filename, "http")) {
            return  $result = $filename;
        }

        if($imageType == "profile") {
            $path = "storage/user/image/" . $thumbnailPath;
        } else if($imageType == "cover") {
            $path = "storage/user/image/cover/" . $thumbnailPath;
        } else if ($imageType == "post") {
            $path = "storage/post/image/" . $thumbnailPath;
        } else {
            // If the image is being deleted to the server
            $path =  "";
        }

        // dd($path, $isThumbnail);
        // check if the file exists
        $isExists = $this->validateFilepath($path, $filename);

        if($isExists) {
            $result = asset($path . $filename);
        } else {
            $result = $this->getDefaultImageLocation($imageType) ;
        }

        return $result;
    }

    function getDefaultImageLocation($imgType) 
    {
        $result = "";

        if($imgType == "profile") {
            $result = "https://api.dicebear.com/avatar.svg";
        } else if ($imgType == "cover" || $imgType == "post") {
            $result = asset("storage/default-img.png");
        } else {
            $result = asset("storage/default-img.png");
        }

        return $result;
    }

    function validateFilepath($path, $filename) {
        if(file_exists(public_path($path, $filename))) {
            return true;
        } return false;
    }


}