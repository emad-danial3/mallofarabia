<?php

namespace App\Http\Repositories;

interface PurchaseInvoiceLinesRepository
{
    public function createLines($item);
    public function getInvoiceLines($order_id);
     public function getAllData($inputData);
}
