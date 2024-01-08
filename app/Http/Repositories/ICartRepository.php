<?php

namespace App\Http\Repositories;

use App\Models\Cart;
use App\Models\CartHeader;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class ICartRepository  extends  BaseRepository implements CartRepository
{

    public function __construct(Cart $model){
             parent::__construct($model);
        }

    public function deleteUserProducts($user_id)
    {
      return  Cart::where([
            "user_id" => $user_id,
        ])->delete();
    }

    public function safeProduct($product, $user_id)
    {
       return Cart::create([
           'user_id'               => $user_id,
           'created_for_user_id'  => $user_id,
           'product_id'           => $product->id,
           'quantity'             => $product->quantity,
           'price'                => $product->price,
           'flag'                 => $product->flag,
           'discount_rate'        => round((((float)$product->price - (float)$product->price_after_discount)*100)/(float)$product->price),
           'price_after_discount' => $product->price_after_discount,
          // 'is_gift' => isset($product->is_gift)&&$product->is_gift>0 ? '1':'0',
           'is_gift' => '0',
       ]);
    }

    public function getMyCartForSpinner($user_id)
    {
       return DB::table('carts')
              ->select('products.id','products.flag','products.full_name','products.name_en'
                  ,'products.name_ar','products.description_en',
                  'products.description_ar','products.image','products.oracle_short_code','discount_rate',
                  'carts.price','carts.price_after_discount','carts.quantity')
              ->join('products','carts.product_id','products.id')
              ->where([
                  'carts.user_id' => $user_id,
                //  'carts.created_for_user_id' => $user_id,
              ])->get();
    }

    public function getMyCart($user_id)
    {
       return Cart::select('carts.user_id','carts.product_id','products.id','carts.quantity','carts.price','carts.is_gift','carts.discount_rate','carts.price_after_discount','carts.flag', 'products.excluder_flag', 'products.old_price', 'products.old_discount', 'products.stock_status',DB::raw("IF(products.stock_status ='in stock',1,0) AS  stock_code"), 'products.name_en', 'products.name_ar', 'products.image', 'products.tax')
           ->leftJoin('products', 'carts.product_id', 'products.id')->where([
          'carts.user_id'             => $user_id,
         // 'carts.created_for_user_id' => $user_id,
       ])->get();
    }
    public function getCartProduct($user_id,$product_id)
    {
      return  Cart::where('product_id',$product_id)->where('user_id',$user_id)->first();
    }
    public function getMyCartHeader($user_id)
    {
       return CartHeader::where([
          'user_id'             => $user_id,
          'created_for_user_id' => $user_id,
       ])->first();
    }

    public function updateMyCart($id,$data)
    {
        return Cart::find($id)->update($data);
    }
    public function deleteOneCartWithUserProduct($user_id,$product_id)
    {
        return Cart::where('user_id',$user_id)->where('product_id',$product_id)->delete();
    }

    public function deleteCartHeader($user_id)
    {
      return  CartHeader::where([
            "user_id" => $user_id,
          //  "created_for_user_id" => $user_id
        ])->delete();
    }

    public function safeCartHeader($user_id, $totalProductsPrice, $totalProductsAfterDiscount,$shipping_amount,$discount_amount)
    {
        return CartHeader::create([
            'user_id'                       => $user_id,
            'created_for_user_id'           => $user_id,
            'total_products_price'          => $totalProductsPrice,
            'total_products_after_discount' => $totalProductsAfterDiscount,
            'shipping_amount'               => $shipping_amount,
            'discount_amount'               => $discount_amount,
            'discount_type'               => 'Fixed',
        ]);
    }

    public function getTotal($user_id):int
    {
       $totalPrice = CartHeader::where([
            'user_id'             => $user_id,
          //  'created_for_user_id' => $user_id,
        ])->select('total_products_after_discount')->first();
        return (isset($totalPrice))? $totalPrice->total_products_after_discount : 0;
    }
    public function getTotalProducts($user_id):int
    {
       $totalProductsPrice = Cart::where([
            'user_id'             => $user_id,
        ])->sum(DB::raw('price * quantity'));
        return (isset($totalProductsPrice))? $totalProductsPrice : 0;
    }
    public function getTotalProductsAfter($user_id):int
    {
       $totalProductsPrice = Cart::where([
            'user_id'      => $user_id,
        ])->sum(DB::raw('price_after_discount * quantity'));
        return (isset($totalProductsPrice))? $totalProductsPrice : 0;
    }

    public function updateHeader($user_id,$data)
    {
      return  CartHeader::where([
            'user_id' => $user_id,
            'created_for_user_id' => $user_id,
        ])->update($data);
    }

    public function updateCartWithGift($user_id , $product_id, $quantity, $price,$price_after_discount,$flag)
    {
        return Cart::create([
           'user_id'              => $user_id,
           'created_for_user_id'  => $user_id,
           'product_id'           => $product_id,
           'quantity'             => $quantity,
           'price'                => $price,
           'flag'                => $flag,
           'price_after_discount' => $price_after_discount
        ]);
    }
}
