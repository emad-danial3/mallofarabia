<?php

namespace App\Http\Repositories;

interface PurchaseInvoiceRepository
{

    public function createOrder($orderHeaderData);
    public function getOrder($order_id);
    public function updateOrder($conditions, $data);
    public function getMyOrder($user_id);
    public function getMyOrderDetails($order_id);
    public function getAllData($inputData);
    public function updateData($conditions , $updatedData);
}
