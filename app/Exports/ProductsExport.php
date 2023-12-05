<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Product;
class ProductsExport implements FromCollection , WithHeadings
{

    private  $products_ids;

    public function __construct($products_ids)
    {
        $this->products_ids = $products_ids;
    }

    public function collection()
    {

        $data=   Product::select(
                        'products.id',
                        'products.full_name',
                        'products.stock_status',
                        'products.name_ar',
                        'products.name_en',
                        'products.price',
                        'products.tax',
                        'products.discount_rate',
                        'price_after_discount',
                        'quantity',
                        'weight',
                        'description_ar',
                        'description_en',
                        'oracle_short_code',
                        'product_categories.id as IntersectionId',
                        'product_categories.product_id',
                        'product_categories.category_id',
                        'categories.id as categoryID',
                        'categories.name_en as categoryNameEn',
                        'categories.name_ar as categoryNameAr',
                        'categories.parent_id',
                        'categories.level',
                        'categories.is_available'
            )
            ->leftJoin('product_categories','product_categories.product_id','=','products.id')
            ->leftJoin('categories','product_categories.category_id','=','categories.id');


        if ($this->products_ids !== "0")
        {
            $data=$data->whereIn('products.id',$this->products_ids);
        }


        $data=$data->get();

        return $data;

    }

    public function headings(): array
    {
        return  [
            'id',
            'full_name',
            'stock_status',
            'name_ar',
            'name_en',
            'price',
            'tax',
            'discount_rate',
            'price_after_discount',
            'quantity',
            'weight',
            'description_ar',
            'description_en',
            'oracle_short_code',
            'IntersectionId',
            'product_categories_product_id',
            'category_id',
            'categoryID',
            'categoryNameEn',
            'categoryNameAr',
            'category_parent_id',
            'category_level',
            'categories_is_available'
            ];
    }
}
