<?php

namespace App\Http\Repositories;

interface CartRepository
{
    public function deleteUserProducts($user_id,$created_for_user_id);
    public function safeProduct($product, $user_id, $created_for_user_id);
    public function getMyCartForSpinner($user_id,$created_for_user_id);
    public function getMyCart($user_id,$created_for_user_id);
    public function getMyCartHeader($user_id, $created_for_user_id);
    public function updateMyCart($id,$data);
    public function deleteCartHeader($user_id,$created_for_user_id);
    public function safeCartHeader($user_id, $created_for_user_id, $totalProductsPrice, $totalProductsAfterDiscount,$shipping_amount,$discount_amount);
    public function getTotal($user_id, $created_for_user_id);
    public function updateHeader($user_id,$created_for_user_id,$data);
    public function updateCartWithGift($user_id, $created_for_user_id , $product_id, $quantity, $price,$price_after_discount,$flag);
}
