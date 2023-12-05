<?php

namespace App\View\Components\Products;

use Illuminate\View\Component;

class ProductCategory extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $categories;
    public $newCategories;
    public $productId;
    public function __construct($categories,$newCategories,$productId)
    {
        //
        $this->categories=$categories;
        $this->newCategories=$newCategories;
        $this->productId=$productId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.products.product-category')->with(['categories'=>$this->categories,'newCategories'=>$this->newCategories,"product"=>$this->productId]);
    }

}
