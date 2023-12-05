<?php

namespace App\Http\Repositories;

use App\Models\AccountType;
use App\Models\Area;
use App\Models\Banner;
use App\Models\City;
use App\Models\Country;
use App\Models\DigitalBrochure;
use App\Models\FAQ;
use App\Models\SharePage;
use App\Models\SharePageCategory;
use App\Models\StaticPages;
use App\Models\WelcomeProgramProduct;

class IGeneralRepository extends BaseRepository implements GeneralRepository
{

    public function __construct(FAQ $model)
    {
        parent::__construct($model);
    }

    public function getFAQ()
    {
        return FAQ::all();
    }

    public function getStaticPages()
    {
        return StaticPages::all();
    }

    public function getBrochure()
    {
        return DigitalBrochure::first();
    }

    public function sharePagesCategory($base_page)
    {
        return SharePageCategory::where(['page_category_source_id' => $base_page])->get();
    }

    public function sharePages($id)
    {
        return SharePage::where(['share_page_category_id' => $id, 'status' => '1'])->get();
    }

    public function getBanners()
    {
        return Banner::orderBy(
            'priority', 'ASC'
        )->orderBy('id', 'DESC')->with(['category' => function ($query) {
            $query->select('id', 'name_en', 'parent_id');
        }])->get();
    }

    public function getCountries()
    {
        return Country::all();
    }

    public function getFirstScreens()
    {
        return WelcomeProgramProduct::where('status', '1')->get();
    }

    public function getCities($id)
    {
        return City::where('country_id', $id)->get();
    }

    public function getAreas($id)
    {
        // return Area::where('city_id',$id)->get();
        return Area::where('city_id', $id)->groupBy('region_en')->orderBy('region_en', 'asc')->select('id', 'region_en as name_en', 'region_ar as name_ar', 'governorate', 'city_id')->get();
    }

    public function getAccountTypes()
    {
        return AccountType::where('is_available', 1)->get();
    }
}
