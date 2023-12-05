<?php

namespace App\Http\Services;

use App\Http\Repositories\OracleProductRepository;

class OracleProductService extends BaseServiceController
{
    private  $OracleProductRepository;

    public function __construct(OracleProductRepository  $OracleProductRepository)
    {
        $this->OracleProductRepository = $OracleProductRepository;
    }

    public function getAll($inputData)
    {
        return $this->OracleProductRepository->getAllData($inputData);
    }
    public function createOrUpdate($inputData)
    {
        return $this->OracleProductRepository->updateOrCreate($inputData);
    }

    public function updatePrices()
    {
        return $this->OracleProductRepository->updatePrices();
    }
    
    public function truncateModel()
    {
        return $this->OracleProductRepository->truncateModel();
    }

    public function find($id)
    {
        return $this->OracleProductRepository->find($id,['*']);
    }
}
