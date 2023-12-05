<?php

namespace App\Http\Controllers\Website;


use App\Http\Controllers\Controller;
use App\Models\DigitalBrochure;

class DigitalBrochureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function digitalBrochure()
    {
        $digitalBrochure=DigitalBrochure::first();
        return view('digitalBrochure',compact('digitalBrochure'));
    }

}
