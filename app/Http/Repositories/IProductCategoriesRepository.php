<?php

namespace App\Http\Repositories;

use App\Models\ProductCategories;

class IProductCategoriesRepository extends BaseRepository implements ProductCategoriesRepository
{
    public function __construct(ProductCategories $model)
    {
        parent::__construct($model);
    }


    public function deleteChunk($productIds,$categoryId){

        ProductCategories::where('category_id',$categoryId)->whereIn('product_id',$productIds)->delete();
    }

    public function insertChunk($productIds,$categoryId){
        $collection = collect($productIds);

        $data=$collection->map(function ($item, $key) use ($categoryId) {return ['category_id'=>$categoryId,'product_id'=>$item];});
        ProductCategories::insert($data->toArray());
    }
}
