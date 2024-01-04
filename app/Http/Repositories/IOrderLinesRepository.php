<?php

namespace App\Http\Repositories;

use App\Models\OrderLine;
use App\Models\Product;

class IOrderLinesRepository extends  BaseRepository implements OrderLinesRepository
{
    public function __construct(OrderLine $model)
    {
        parent::__construct($model);
    }

    public function getMaxNumber():int
    {
        $order_lines=OrderLine::select('id','max')->orderBy('id', 'desc')->first();
        return (isset($order_lines))? $order_lines->max : 0;
    }

    public function createLines($orderLineData, $order_id, $oracle_num,$max)
    {
        $oldpro=OrderLine::where('order_id', $order_id)->where('product_id', $orderLineData['product_id'])->first();
        if(empty($oldpro)){
            OrderLine::create([
            'order_id'   => $order_id,
            'product_id' => $orderLineData['product_id'],
            'price'      =>   $orderLineData['price_after_discount'],
            'tax'      =>   $orderLineData['tax'],
            'quantity'   => $orderLineData['quantity'] > 0 ?$orderLineData['quantity'] : 1,
            'oracle_num' => $oracle_num,
            'discount_rate' => round((((float)$orderLineData['price'] - (float)$orderLineData['price_after_discount'])*100)/(float)$orderLineData['price']),
            'price_before_discount' => $orderLineData['price'],
            'max'        => $max,
            'is_gift' => isset($orderLineData->is_gift)&&$orderLineData->is_gift>0 ? '1':'0',
        ]);
        }
    }
    public function getOrderLines($order_id)
    {
      return  OrderLine::where('order_id',$order_id)->get();
    }
}
