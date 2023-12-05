<?php

namespace App\Http\Repositories;

use App\Models\Category;

class ICategoriesRepository extends BaseRepository implements CategoriesRepository
{
    public function __construct(Category $model){
        parent::__construct($model);
    }

    public function updateData($conditions, $updatedData)
    {
        return Category::where($conditions)->update($updatedData);
    }

    public function getMyChild($parent_id)
    {
       return Category::where(['parent_id' => $parent_id])->get();
    }

    public function getAllSubCategories()
    {
        return Category::whereNotNull('parent_id') ->orderBy('parent_id')->get();
    }


    public function getMyParent($child_id)
    {

    }
}
