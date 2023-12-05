<?php

namespace App\Http\Repositories;

interface OracleProductRepository
{
    public function updateOrCreate($product);
    public function updatePrices();
     public function truncateModel();
    public function getAllData($inputData);
}
