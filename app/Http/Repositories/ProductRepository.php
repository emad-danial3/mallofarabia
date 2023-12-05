<?php

namespace App\Http\Repositories;

interface ProductRepository
{
    public function  getAllProducts($inputData,$has_discount);
    public function  getBestProducts($inputData,$has_discount);
    public function  calculatePrice($conditions, $selectedColumn);
    public function getAllData($inputData);
    public function updateData($conditions , $updatedData);
    public function createProduct($inputData);
    public function changeStatus($product_ids , $status);
}
