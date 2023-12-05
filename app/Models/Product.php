<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends AbstractModel
{
    use HasFactory;
    protected $guarded=['id'];

    public function productCategory(){

        return $this->hasMany(ProductCategories::class)->with('category')->orderBy('category_id');
    }
}
