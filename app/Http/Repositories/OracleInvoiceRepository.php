<?php

namespace App\Http\Repositories;

interface OracleInvoiceRepository
{
    public function updateOrCreate($invoice);
    public function updateInvoices();
    public function getOrdersNotSentToOracle();
    public function ordersCountSentToOracleNotReturn();
     public function truncateModel();
    public function getAllData($inputData);
}
