<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends AbstractModel
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function productStock(){
        return $this->belongsToMany(Product::class,'product_categories')->where('stock_status','in stock')->select('id');
    }

    public function Products(){
        return $this->belongsToMany(Product::class,'product_categories')->select('products.id');
    }
    public function sub(){
        return $this->hasMany(Category::class,'parent_id','id');
    }

}
