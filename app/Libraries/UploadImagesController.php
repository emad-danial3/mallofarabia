<?php

namespace App\Libraries;
use Exception;
class UploadImagesController
{
    public $imageName;
    public   function UploadImage($file,$folder)
    {
        try {
            $rand=rand(0,1000000);
            $imageName = time().$rand.'.'.$file->extension();
            $this->imageName = $folder.'/'.$imageName;
            $file->move(public_path($folder), $imageName);
            return $folder.'/'.$imageName;
        }
        catch (\Exception $exception)
        {
            return  false;
        }
    }
}
