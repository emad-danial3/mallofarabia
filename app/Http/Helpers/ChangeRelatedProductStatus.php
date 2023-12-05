<?php

namespace App\Http\Helpers;

use App\Http\Repositories\IProductRepository;

trait ChangeRelatedProductStatus
{

    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function updateProducts($updatedData , $id){
        $productIds=$this->productRepository->getAll(['id'],['flag'=>$id]);

        if ($updatedData['is_available']==0){
            $this->productRepository->changeStatus($productIds,'out stock');
        }else{
            $this->productRepository->changeStatus($productIds,'in stock');
        }

    }
}
