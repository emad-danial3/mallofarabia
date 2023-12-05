<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\Models\Filter;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    private $API_RESPONSE;

    public function __construct(ApiResponse $API_RESPONSE)
    {
        $this->API_RESPONSE = $API_RESPONSE;
    }

    public function getFilters(Request $request)
    {
        $filters = Filter::where('is_available', 1)->take(9)->get();
        return $this->API_RESPONSE->data(['categories' => $filters], 'categories', 200);
    }

}
