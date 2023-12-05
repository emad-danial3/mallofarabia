<?php

namespace App\Http\Repositories;

interface AreaRepository
{
    public function getAllAreas($inputData);
    public function updateArea($conditions , $updatedData);
}
