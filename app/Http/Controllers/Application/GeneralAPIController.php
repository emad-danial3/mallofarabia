<?php

namespace App\Http\Controllers\Application;


use App\Http\Services\GeneralService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\Libraries\MediaController;
use App\Models\Area;
use App\Models\City;
use App\ValidationClasses\GeneralValidation;
use Illuminate\Http\Request;

class GeneralAPIController extends HomeController
{
    protected  $API_VALIDATOR;
    protected  $API_RESPONSE;
    protected  $GeneralService;
    protected  $GeneralValidation;
    protected  $MediaController;

    public function __construct(ApiValidator  $apiValidator,ApiResponse  $API_RESPONSE, GeneralService $GeneralService, GeneralValidation  $GeneralValidation, MediaController $MediaController)
    {
        $this->API_VALIDATOR     = $apiValidator;
        $this->API_RESPONSE      = $API_RESPONSE;
        $this->GeneralService    = $GeneralService;
        $this->GeneralValidation = $GeneralValidation;
        $this->MediaController   = $MediaController;
    }

    public function FAQ(Request  $request)
    {
        $FAQ = $this->GeneralService->getFAQ();
        return $this->API_RESPONSE->data(['FAQ' => $FAQ],'FAQ',200);
    }

    public function staticPages(Request  $request)
    {
        $staticPages = $this->GeneralService->getStaticPages();
        return $this->API_RESPONSE->data(['static_pages' => $staticPages],'Static Pages',200);
    }

    public function getBrochure(Request  $request)
    {
        $getBrochure = $this->GeneralService->getBrochure();
        return $this->API_RESPONSE->data($getBrochure,'Brochure',200);
    }

    public function sharePagesCategory(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->GeneralValidation->page_category());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }

        $staticPages = $this->GeneralService->sharePagesCategory($request->input('page_category_source'));
        return $this->API_RESPONSE->data(['share_pages_category' => $staticPages],'Share Pages Category',200);
    }

    public function sharePages($id)
    {
        $staticPages = $this->GeneralService->getSharePages($id);
        return $this->API_RESPONSE->data(['share_pages' => $staticPages],'Share Pages',200);
    }

    public function Banners()
    {
        $Banners = $this->GeneralService->getBanners();
        return $this->API_RESPONSE->data(['Banners' => $Banners ],'Banners',200);
    }

    public function uploadImage(Request  $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->GeneralValidation->uploadImages());
        if ($validator) {
            $errorMessages=[];
            foreach ($validator->keys() as $error) {
                $errorMessages[] = trans('validation.'.$error);
            }
            return $this->API_RESPONSE->errors($errorMessages,400);
        }
        $link = $this->MediaController->UploadImage($request->file('image'),'images');
        return $this->API_RESPONSE->data(['link' => $link ],'Link',201);
    }

    public function country()
    {
        $countries = $this->GeneralService->getCountries();
        return $this->API_RESPONSE->data(['countries' => $countries],'Countries',200);
    }
    public function getFirstScreens()
    {
        $Screens = $this->GeneralService->getFirstScreens();
        return $this->API_RESPONSE->data(['Screens' => $Screens],'Screens',200);
    }

    public function city($id)
    {
        $cities = $this->GeneralService->getCities($id);
        return $this->API_RESPONSE->data(['cities' => $cities],'Cities',200);
    }

    public function area($id)
    {
        $areas = $this->GeneralService->getAreas($id);
        return $this->API_RESPONSE->data(['areas' => $areas],'Areas',200);
    }

    public function AccountTypes()
    {
        $types = $this->GeneralService->getAccountTypes();
        return $this->API_RESPONSE->data(['account_types' => $types],'Account Types',200);
    }


}
