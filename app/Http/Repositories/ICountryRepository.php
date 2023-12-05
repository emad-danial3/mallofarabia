<?php

namespace App\Http\Repositories;

use App\Models\Country;

class ICountryRepository extends BaseRepository implements CountryRepository
{
    public function __construct(Country $model){
        parent::__construct($model);
    }

    public function getAllCountries($inputData)
    {
        $country = Country::orderBy('id','asc');
        if (isset($inputData['name']))
        {
            $country->where('name_en','like','%'.$inputData['name'].'%');
        }
        return  $country->paginate($this->defaultLimit);
    }

    public function updateCountry($conditions, $updatedData)
    {
       return Country::where($conditions)->update($updatedData);
    }
}
