<?php

namespace App\Http\Helpers;

use App\Events\sendMail;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\ICartRepository;
use App\Http\Services\CartService;
use App\Models\ProductModule\ProductOption;
use Illuminate\Support\Facades\Mail;

/*
     * get products from cart liens
     * subtract quantity from products
     * if the result with nigative return out of stock quantity and return error with no creating for the order
     * else subtract from stock and return true to create orders
     * if true check if the quantity is zero mad it outofstock
     * send report to ramy if there is out of stock or minis case
     * */

    /*
     * check if the order expired return the quantity back
     * */
trait StockManagement
{
    protected  $CartRepository;
    protected  $productsIssuesIds =[];

    protected $productIssued;


    protected function checkStockAvailability($user_id, $created_for_user_id){


        $zeroQuantityProductsIssuesIds =[];
        $getCartLines      = $this->CartService->getCartLines($user_id,$created_for_user_id);

        foreach ($getCartLines as $key => $orderLine)
        {

            $statusOption=$this->checkStockAvailabilityOptions($orderLine);

            if (!$statusOption)
                return $statusOption;
            $newQuantity=$orderLine->product->quantity-$orderLine->quantity;

            if ($newQuantity < 0)
                $this->productsIssuesIds[]=$orderLine->product_id;
            elseif($newQuantity == 0)
                $zeroQuantityProductsIssuesIds[]=$orderLine->product_id;
        }

        if (!empty($this->productsIssuesIds)){
//            event(new sendMail(["khaled.abodaif@yahoo.com"],$this->productsIssuesIds,"Too LOW Items"));
            return false;
        }

        if (!empty($zeroQuantityProductsIssuesIds)){
//            event(new sendMail(["khaled.abodaif@yahoo.com"],$this->productsIssuesIds,"Out Of Stock Items"));
            $this->ProductService->changeStatus($zeroQuantityProductsIssuesIds,'out stock');

        }

        foreach ($getCartLines as $key => $orderLine)
        {
            $orderLine->product->decrement('quantity',$orderLine->quantity);
            $orderLine->product->save();
        }
            return true;


    }

    protected function checkStockAvailabilityOptions($orderLine)
    {

        foreach ($orderLine->options as $option) {

            if (count($orderLine->product->getAttr) > 0) {


                $newQuantity = ProductOption::where('option_value_id',$option->option_value_id)
                        ->where('product_id',$orderLine->product_id)->first()->quantity
                         - $option->quantity;

                if ($newQuantity < 0)
                    $this->productsIssuesIds[] = $orderLine->product_id;
                elseif ($newQuantity == 0)
                    ProductOption::where('product_id', $orderLine->product_id)
                        ->where('option_value_id',$option->option_value_id)
                        ->update(['status'=> 'out stock']);

                ProductOption::where('product_id', $orderLine->product_id)
                    ->where('option_value_id',$option->option_value_id)
                    ->update(['quantity'=> $newQuantity]);

            }
        }
            if (!empty($this->productsIssuesIds)) {
//            event(new sendMail(["khaled.abodaif@yahoo.com"],$this->productsIssuesIds,"Too LOW Items"));
                return false;
            }




        return true;

    }

    protected function incrementStockProducts($orderId){
        $lines=$this->OrderLinesService->getOrderLines($orderId);

        foreach ($lines as $key => $orderLine)
        {

            $orderLine->product->increment('quantity',$orderLine->quantity);
            if ($orderLine->product->stock_status == 'out stock')
                $orderLine->product->stock_status='in stock';
            $orderLine->product->save();
        }
    }




}
