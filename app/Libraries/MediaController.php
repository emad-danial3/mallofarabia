<?php

namespace App\Libraries;

class MediaController
{

    public   function UploadImage($request,$folder)
    {
        if (request()->hasFile('image')) {
            $imageName = time().'.'.$request->extension();
            $request->move(public_path($folder), $imageName);
            return $folder.'/'.$imageName;
        }
        else {
            return false;
        }
    }
    public static  function UploadImages($request,$folder)
    {
        if (request()->hasFile('images')) {
            $images=[];
            foreach ($request as $image){
                $imageName = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path($folder), $imageName);
                $images[]=$folder.'/'.$imageName;
            }

            return $images;
        }
        else {
            return false;
        }
    }

    public static  function UpdateImage($request,$folder,$url)
    {
        if (request()->hasFile('image')) {
            @unlink($url);
            $imageName = time().'.'.$request->extension();
            $request->move(public_path($folder), $imageName);
            return $folder.'/'.$imageName;
        }
        else {
            return false;
        }
    }
    public static  function DeleteImage($url)
    {
            @unlink($url);
            return true;

    }
    public static  function DeleteImages($urls)
    {
        if (!empty($urls))
        foreach ($urls as $url){
            @unlink($url->image);

        }
            return true;

    }


}
