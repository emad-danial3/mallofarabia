<?php

namespace App\Http\Repositories;

interface CityRepository
{
    public function  getAllCities($inputData);
    public function  updateCity($conditions , $updatedData);
}
