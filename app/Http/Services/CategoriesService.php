<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoriesRepository;
use App\Models\Category;

class CategoriesService extends BaseServiceController
{
    private  $CategoriesRepository;

    public function __construct(CategoriesRepository  $CategoriesRepository)
    {
        $this->CategoriesRepository = $CategoriesRepository;
    }

    public function getCategories($parent_id = NULL)
    {

//     return Category::where(['parent_id' => $parent_id])
//            ->select(['id', 'name_en', 'name_ar','image'])
//            ->withCount('productStock')
//            ->having('product_stock_count', '>', 0)
//            ->where('is_available',1)
//            ->get()
//            ->makeHidden('product_stock_count');
            return   $this->CategoriesRepository->getAll(['id', 'name_en', 'name_ar','image'], ['parent_id' => $parent_id]);
    }


}
