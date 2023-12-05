<?php

namespace App\Http\Controllers\Application;

use App\Http\Services\CategoriesService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use Illuminate\Http\Request;

class CategoriesController extends HomeController
{
    private  $API_VALIDATOR;
    private  $API_RESPONSE;
    private  $CategoriesService;

    public function __construct(ApiValidator  $apiValidator, ApiResponse  $API_RESPONSE, CategoriesService $CategoriesService)
    {
        $this->API_RESPONSE      = $API_RESPONSE;
        $this->API_VALIDATOR     = $apiValidator;
        $this->CategoriesService = $CategoriesService;
    }

    public function getCategories(Request  $request)
    {
        $parent_id = $request->input('parent_id');
        $main_categories = $this->CategoriesService->getCategories($parent_id);
        return $this->API_RESPONSE->data(['brands'=>$main_categories],'Brands',200);
    }
}
