<?php

namespace App\Http\Services;

use App\Http\Repositories\AreaRepository;

class AreaService extends  BaseServiceController
{

    private $AreaRepository;

    public function __construct(AreaRepository $AreaRepository)
    {
        $this->AreaRepository = $AreaRepository;
    }

    public function getAllAreas($inputData)
    {
        return $this->AreaRepository->getAllAreas($inputData);
    }

    public function updateAreaRow($updatedData , $id)
    {
        return  $this->AreaRepository->updateArea(['id' => $id] ,$updatedData);
    }

    public function createAreaRow($inputData)
    {
        return  $this->AreaRepository->create($inputData);
    }

}
