<?php

namespace App\Services;

class ImageLinkService
{
    protected $defaultProfileImgLink    = "https://api.dicebear.com/avatar.svg";
    protected $defaultCoverImgLink      = "storage/default-img.png";
    protected $defaultPostImgLink       = "storage/default-img.png";

    public function imageStorageLocation($filename = "", $imageFor = "profile")
    {
        $imageLocation = "";
// dd($filename, $imageFor);
        if( $filename ) {
            $imageLocation = $this->getImageLocation($imageFor, $filename);
        } else {
            $imageLocation = $this->getDefaultImageLocation($imageFor);
        }
// dd($imageLocation);
        return $imageLocation;
    }

   
    function getImageLocation($imageFor, $filename)
    {
        $result = "";

        if (str_contains($filename, "http")) {
            return  $result = $filename;
        }

        if($imageFor == "profile") {
            $result = asset("storage/user/image/" . $filename);
        } else if($imageFor == "cover") {
            $result = asset("storage/user/image/cover/" . $filename);
        } else if ($imageFor == "post") {
            $result = asset("storage/post/" . $filename);
        } else {
            $result = "";
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
            $result = "";
        }

        return $result;
    }


}