<?php

namespace App\Http\Repositories;

use App\Models\OracleProducts;
use App\Models\Product;
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
            return (OracleProducts::where('item_code', $product->item_code)->count()) ? OracleProducts::where('item_code', $product->item_code)->update([
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
            ]) : OracleProducts::create([
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

    public function updatePrices()
    {

        $this->insertProductsNotExist();
        $this->updateProductsNotInOracle();
        $now            = Carbon::now()->toDateTimeString();
        $oracleproducts = DB::table('oracle_products')->select('cust_price','percentage_rate', 'item_code', 'quantity', 'discount_rate', 'excluder_flag', 'segment3', 'company_name')->get();

        foreach ($oracleproducts as $oracleproduct) {

            if (isset($oracleproduct) && $oracleproduct && isset($oracleproduct->cust_price)) {
                $product = Product::where('oracle_short_code', $oracleproduct->item_code)->first();
                if (!empty($product)) {
                    $discountRate = 0;
                    if ($oracleproduct->excluder_flag == 'Y') {
                        $discountRate = $oracleproduct->discount_rate;
                    }
                    elseif ($oracleproduct->segment3 == 'Magic Touch' || $oracleproduct->segment3 == 'Man Look MT' || $oracleproduct->segment3 == 'Eva Care MT'|| $oracleproduct->segment3 == 'Aloe Eva MT'|| $oracleproduct->segment3 == 'One MT') {
                        $discountRate = 30;
                    }
                    else {
                        $discountRate = 25;
                    }
                    $cust_price=(float)$oracleproduct->cust_price;
                    $newData = [
                        "price"                => $cust_price,
                        "quantity"             => $oracleproduct->quantity,
                        "stock_status"         => $oracleproduct->quantity > 10 ?"in stock":"out stock",
                        "tax"                  => $oracleproduct->percentage_rate,
                        "excluder_flag"        => $oracleproduct->excluder_flag,
                        "discount_rate"        => $discountRate,
                        "price_after_discount" => ($cust_price - ($cust_price * $discountRate/ 100))
                    ];

                    $product->update($newData);
                }
            }
        }


//        return DB::select("update products as  t1 ,(
//                        select cust_price , percentage_rate ,item_code,quantity,discount_rate,excluder_flag from oracle_products
//                        ) as t2 set
//                        t1.price = t2.cust_price
//                        , t1.tax = t2.percentage_rate
//                         , t1.quantity = t2.quantity
//                                   , t1.discount_rate = t2.discount_rate
//                                   , t1.excluder_flag = t2.excluder_flag
//                        , t1.price_after_discount = (t2.cust_price - ((t2.cust_price * t2.discount_rate) /100) ),t1.updated_at = '{$now}'
//                        where t1.oracle_short_code  = t2.item_code
//                         ");

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
            })->whereIn('products.flag', [5, 8, 9, 23,7])->whereNull('oracle_products.id')->update(['products.stock_status' => 'out stock']);

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
