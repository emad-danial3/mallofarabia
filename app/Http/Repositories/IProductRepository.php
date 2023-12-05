<?php

namespace App\Http\Repositories;

use App\Constants\OrderTypes;
use App\Constants\ProductStatus;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class IProductRepository extends BaseRepository implements ProductRepository
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAllProducts($inputData, $has_discount)
    {

        $offset       = empty($inputData['offset']) ? 0 : $inputData['offset'];
        $productsbest = DB::table('order_lines')
            ->select('order_lines.product_id', DB::raw('(select SUM(quantity) from order_lines ol where ol.product_id=order_lines.product_id ) as  sumQuantity'))->orderBy('sumQuantity', 'DESC')->groupBy('order_lines.product_id');
        $productsbest = $productsbest->take(50)->get()->toArray();
        $productsbest = array_column($productsbest, 'product_id');
        $productsbest = implode(",", $productsbest);

        $products = Product::select('products.excluder_flag','products.id', 'products.flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate', 'products.old_price',
             'products.price_after_discount', 'products.quantity'
            , DB::raw("(IF(products.excluder_flag ='Y',products.price_after_discount,products.price)) as  price"), DB::raw("(IF(products.excluder_flag ='Y',products.discount_rate,products.old_discount)) as  old_discount")
            , DB::raw(" (IF(FIND_IN_SET(products.id,'" . $productsbest . "') > 0,1,0))  as is_best_sale"))
            ->where('products.visible_status', '1')
            ->where('products.stock_status', 'in stock');

        if (isset($inputData['name']) && $inputData['name'] != '') {
            $products->where('products.name_en', 'like', '%' . $inputData['name'] . '%')->orWhere('products.name_ar', 'like', '%' . $inputData['name'] . '%')->orWhere('products.oracle_short_code', 'like', '%' . $inputData['name'] . '%');
        }
        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $products->join('product_categories', 'product_categories.product_id', 'products.id')
                ->where('product_categories.category_id', $inputData['category_id']);
        }
        if (isset($inputData['filter_id']) && $inputData['filter_id'] != '') {
            $products->where('products.filter_id', $inputData['filter_id']);
        }
//         dd($products->get());
        $products = $products->skip($this->getOffset())
            ->take($this->getLimit())->get();
        return $products;
    }

    public function getBestProducts($inputData, $has_discount)
    {

         $offset   = empty($inputData['offset']) ? 0 : $inputData['offset'];
        $products = DB::table('order_lines')
            ->join('products', 'order_lines.product_id', 'products.id')
            ->select('products.excluder_flag','order_lines.product_id', DB::raw('(select SUM(quantity) from order_lines ol where ol.product_id=order_lines.product_id ) as  sumQuantity'),
                'products.id', 'products.flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
                'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate', 'products.old_price'
               , DB::raw("(IF(products.excluder_flag ='Y',products.price_after_discount,products.price)) as  price"), DB::raw("(IF(products.excluder_flag ='Y',products.discount_rate,products.old_discount)) as  old_discount"), 'products.price_after_discount', 'products.quantity', DB::raw(" (IF(products.id > 0,1,0))  as is_best_sale")
            )->where('products.stock_status', 'in stock')->where('products.visible_status', '1')->orderBy('sumQuantity', 'DESC')->groupBy('order_lines.product_id');
        $products = $products->skip($this->getOffset())
            ->take($this->getLimit())->get();
        return $products;
    }

    public function calculatePrice($conditions, $selectedColumn)
    {
        return Product::select($selectedColumn)->where($conditions)->first();
    }

    public function getAllData($inputData)
    {


        $data = Product::select('products.*')->orderBy('id', 'asc');

        if (isset($inputData['name'])) {
            $data->where('name_en', 'like', '%' . $inputData['name'] . '%');
        }

        if (isset($inputData['item_code'])) {
            $data->where('oracle_short_code', 'like', '%' . $inputData['item_code'] . '%');
        }
        if (isset($inputData['barcode'])) {
            $data->where('barcode', 'like', '%' . $inputData['barcode'] . '%');
        }

        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $data->join('product_categories', 'product_categories.product_id', 'products.id')
                ->where('product_categories.category_id', $inputData['category_id']);
        }
        $data->with('productCategory');
        return $data->paginate(100);
    }

    public function updateData($conditions, $updatedData)
    {
        return Product::where($conditions)->update($updatedData);
    }

    public function createProduct($inputData)
    {
        Product::create($inputData);
        return DB::getPdo()->lastInsertId();
    }

    public function changeStatus($product_ids, $status)
    {
        return Product::whereIn('id', $product_ids)->update([
            'stock_status' => $status
        ]);
    }
}
