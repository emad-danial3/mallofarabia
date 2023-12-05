<?php

namespace App\Http\Repositories;

use App\Models\Area;

class IAreaRepository extends BaseRepository implements AreaRepository
{

    public function __construct(Area $model)
    {
        parent::__construct($model);
    }
    public function getAllAreas($inputData)
    {
        $user = Area::orderBy('id','asc');
        if (isset($inputData['name']))
        {
            $user->where('name_en','like','%'.$inputData['name'].'%');
        }
        return  $user->paginate($this->defaultLimit);
    }

    public function updateArea($conditions, $updatedData)
    {
        return Area::where($conditions)->update($updatedData);
    }
}
