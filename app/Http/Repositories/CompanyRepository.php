<?php

namespace App\Http\Repositories;

interface CompanyRepository
{
    public function updateData($conditions , $updatedData);
}
