<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\IProductRepository;

class CompanyService extends BaseServiceController
{
    private $CompanyRepository;
    private $productRepository;

    public function __construct(CompanyRepository  $CompanyRepository,IProductRepository $productRepository)
    {
        $this->CompanyRepository = $CompanyRepository;
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->CompanyRepository->getAll(['*']);
    }

    public function updateRow($updatedData , $id)
    {
        return  $this->CompanyRepository->updateData(['id' => $id] ,$updatedData);
    }

    public function createRow($inputData)
    {
        return  $this->CompanyRepository->create($inputData);
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
