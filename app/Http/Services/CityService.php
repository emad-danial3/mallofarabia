<?php

namespace App\Http\Services;

use App\Http\Repositories\CityRepository;

class CityService extends BaseServiceController
{
    private  $CityRepository;

    public function __construct(CityRepository  $CityRepository)
    {
        $this->CityRepository = $CityRepository;
    }

    public function getAllCities($inputData)
    {
        return $this->CityRepository->getAllCities($inputData);
    }

    public function updateCityRow($updatedData , $id)
    {
        return  $this->CityRepository->updateCity(['id' => $id] ,$updatedData);
    }

    public function createCityRow($inputData)
    {
        return  $this->CityRepository->create($inputData);
    }

    public function getAllCitiesWithOutPagination()
    {
        return $this->CityRepository->getAll(['id','name_en','name_ar']);
    }
}
