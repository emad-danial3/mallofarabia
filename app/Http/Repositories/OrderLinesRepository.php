<?php

namespace App\Http\Repositories;

interface OrderLinesRepository
{
    public function getMaxNumber();
    public function createLines($orderLineData, $order_id, $oracle_num,$max);
    public function getOrderLines($order_id);
}
