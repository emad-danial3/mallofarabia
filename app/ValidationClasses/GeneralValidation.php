<?php

namespace App\ValidationClasses;

class GeneralValidation
{

    public static function uploadImages()
    {
        return[
            'image' => 'required',
        ];
    }

    public static function area()
    {
        return[
            'city' => 'required',
            'lang' => 'required',
        ];
    }

    public static function page_category()
    {
        return[
            'page_category_source' => 'required|exists:page_category_sources,id',
        ];
    }

}
