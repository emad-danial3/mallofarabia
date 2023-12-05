<?php

namespace App\Http\Repositories;

interface CountryRepository
{
    public function  getAllCountries($inputData);
    public function  updateCountry($conditions , $updatedData);
}
