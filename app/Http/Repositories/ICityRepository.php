<?php

namespace App\Http\Repositories;

use App\Models\City;

class ICityRepository extends BaseRepository  implements CityRepository
{

    public function __construct(City $model)
    {
        parent::__construct($model);
    }
    public function getAllCities($inputData)
    {
        $city = City::orderBy('id','asc');
        if (isset($inputData['name']))
        {
            $city->where('name_en','like','%'.$inputData['name'].'%');
        }
        return  $city->paginate($this->defaultLimit);
    }

    public function updateCity($conditions, $updatedData)
    {
        return City::where($conditions)->update($updatedData);
    }
}
