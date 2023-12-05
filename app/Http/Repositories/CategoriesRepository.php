<?php

namespace App\Http\Repositories;

interface CategoriesRepository
{
    public function updateData($conditions , $updatedData);
    public function getMyChild($parent_id);
    public function getAllSubCategories();
    public function getMyParent($child_id);
}
