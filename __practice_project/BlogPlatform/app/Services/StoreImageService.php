<?php

namespace App\Services;

class StoreImageService
{
    /**
     * @requestFile filename of the image $request->file('user_image')
     * @foldername actual folder like => user/image
     * @isThumbnail boolean
     */
    public static function saveImageTo($requestFile, $foldername , $isThumbnail = false, $width = 150, $height = 93)
    {
        $fileExtension = $requestFile;

        $filename = pathinfo($fileExtension, PATHINFO_FILENAME);

        $extension = $requestFile->getClientOriginalExtension();

        $filenameToStore = $filename  . '_' . time() . '.' . $extension;

        $requestFile->storeAs("public/".$foldername, $filenameToStore);
        
        if($isThumbnail) {
            $requestFile->storeAs("public/".$foldername."/thumbnail", $filenameToStore);
    
            $thumbnail = "storage/".$foldername."/"."thumbnail/" . $filenameToStore;
    
            ThumbnailService::createThumbnail($thumbnail, $width, $height);
        }

        return $filenameToStore;
        
    }
}