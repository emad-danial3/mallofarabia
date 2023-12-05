<?php

namespace App\Http\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class ICompanyRepository extends BaseRepository implements CompanyRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    public function updateData($conditions, $updatedData)
    {
        return Company::where($conditions)->update($updatedData);
    }
}
