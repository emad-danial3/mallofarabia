<?php

namespace App\Http\Services;

use App\Http\Repositories\CountryRepository;

class CountryService extends BaseServiceController
{

    private  $CountryRepository;

    public function __construct(CountryRepository  $CountryRepository)
    {
        $this->CountryRepository = $CountryRepository;
    }

    public function getAllCountries($inputData)
    {
       return $this->CountryRepository->getAllCountries($inputData);
    }

    public function updateCountryRow($updatedData , $id)
    {
        return  $this->CountryRepository->updateCountry(['id' => $id] ,$updatedData);
    }

    public function createCountryRow($inputData)
    {
        return  $this->CountryRepository->create($inputData);
    }

    public function getAllCountriesWithOutPagination()
    {
        return $this->CountryRepository->getAll(['id','name_en','name_ar']);
    }
}
