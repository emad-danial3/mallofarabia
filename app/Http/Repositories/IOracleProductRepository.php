<?php

namespace App\Http\Repositories;

use App\Models\OracleProducts;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ReturnOrderLine;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IOracleProductRepository extends BaseRepository implements OracleProductRepository
{
    public function __construct(OracleProducts $model)
    {
        parent::__construct($model);
    }

    public function updateOrCreate($product)
    {
        $product->percentage_rate = isset($product->percentage_rate) && $product->percentage_rate > 0 ? $product->percentage_rate : 0;
        if (isset($product->item_code))
        {

            $old_product = OracleProducts::where('item_code', $product->item_code)->first() ;
            if($old_product)
            {
                $old_product->update([
                "description"     => $product->description,
                "segment4"        => $product->segment4,
                "segment3"        => $product->segment3,
                "segment7"        => $product->segment7,
                "company_name"    => $product->segment1,
                "cust_price"      => $product->cust_price,
                "discount_rate"   => $product->discount,
                "excluder_flag"   => $product->excluder_flag,
                "quantity"        => $product->quantity,
                "percentage_rate" => $product->percentage_rate,
                ]);
            }
            else
            {
                OracleProducts::create([
                "item_code"       => $product->item_code,
                "description"     => $product->description,
                "segment4"        => $product->segment4,
                "segment3"        => $product->segment3,
                "segment7"        => $product->segment7,
                "company_name"    => $product->segment1,
                "cust_price"      => $product->cust_price,
                "discount_rate"   => $product->discount,
                "excluder_flag"   => $product->excluder_flag,
                "quantity"        => $product->quantity,
                "percentage_rate" => $product->percentage_rate,
                ]);
            }
        }

    }

    public function updatePrices()
    {

        $this->insertProductsNotExist();
        $this->updateProductsNotInOracle();
        $oracleproducts = DB::table('oracle_products')->select('cust_price','percentage_rate', 'item_code', 'quantity', 'discount_rate', 'excluder_flag', 'segment3', 'company_name')->get();

        foreach ($oracleproducts as $oracleproduct) {

            if (isset($oracleproduct) && $oracleproduct && isset($oracleproduct->cust_price)) {
                $product = Product::where('oracle_short_code', $oracleproduct->item_code)->first();
                if (!empty($product)) {


                    $todayProductQuantity = OrderLine::join('order_headers', 'order_headers.id', '=', 'order_lines.order_id')
                    ->join('shifts', 'order_headers.shift_id', '=', 'shifts.id')
                        ->where('product_id', $product->id)
                        ->where('shifts.is_valid', '=', 0)
                        ->sum('order_lines.quantity');
                     $todayProductQuantityReturned = ReturnOrderLine::join('return_order_headers', 'return_order_headers.id', '=', 'return_order_lines.order_id')
                    ->join('shifts', 'return_order_headers.shift_id', '=', 'shifts.id')
                        ->where('product_id', $product->id)
                        ->where('shifts.is_valid', '=', 0)
                        ->sum('return_order_lines.quantity');
                      
                    $cust_price=(float)$oracleproduct->cust_price;
                    $new_q =
                      (int) $oracleproduct->quantity
                    - (int) $todayProductQuantity
                    + (int) $todayProductQuantityReturned ;
                    /*   if($product->oracle_short_code == 91085)
                    {
                        dd($new_q);
                    }*/
                    $newData = [
                        "price"                => $cust_price,
                        "quantity"             => $new_q,
                        "stock_status"         => $new_q >= 1 ?"in stock":"out stock",
                        "tax"                  => $oracleproduct->percentage_rate,
                        "excluder_flag"        => $oracleproduct->excluder_flag,
                    ];

                    $product->update($newData);
                }
            }
        }




    }

    public function getAllData($inputData)
    {
        $code = (isset($inputData['item_code'])) ? $inputData['item_code'] : '';
        return DB::select("SELECT * FROM oracle_products WHERE item_code NOT IN (SELECT oracle_short_code FROM products) and item_code like '%{$code}%'");
    }

    public function updateProductsNotInOracle()
    {
        return DB::table('products')
            ->leftJoin('oracle_products', function ($join) {
                $join->on('products.oracle_short_code', '=', 'oracle_products.item_code');
            })->whereIn('products.flag', [5, 8, 9, 23,7])->whereNull('oracle_products.id')->update(['products.stock_status' => 'out stock','products.quantity' => '0']);

    }

    public function insertProductsNotExist()
    {
        $products = DB::table('oracle_products')
            ->leftJoin('products', function ($join) {
                $join->on('oracle_products.item_code', '=', 'products.oracle_short_code');
            })->whereIn('oracle_products.company_name', ['Cosmetics', 'Food','MoreByEva'])->whereNull('products.id')->select('oracle_products.*')->get();
        foreach ($products as $product) {
            $newData = [
                "full_name"            => $product->description,
                "flag"                 => $product->company_name == 'Cosmetics' ? 5 : 9,
                "name_ar"              => $product->description,
                "name_en"              => $product->description,
                "price"                => $product->cust_price,
                "tax"                  => $product->percentage_rate,
                "discount_rate"        => $product->discount_rate,
                "excluder_flag"        => $product->excluder_flag,
                "price_after_discount" => $product->cust_price - (($product->cust_price * $product->discount_rate) / 100),
                "quantity"             => $product->quantity,
                "description_ar"       => $product->description,
                "description_en"       => $product->description,
                "oracle_short_code"    => $product->item_code,
                "image"                => '',
                "filter_id"            => 1,
                "old_price"            => $product->cust_price,
                "old_discount"         => 0,
            ];

            Product::create($newData);
        }

        return true;
    }

    public function truncateModel()
    {
        return OracleProducts::truncate();
    }

}
