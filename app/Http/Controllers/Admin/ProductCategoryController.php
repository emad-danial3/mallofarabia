<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesRequest;
use App\Http\Requests\category\changeStatus;
use App\Http\Requests\Product\AddCategoryProductRequest;
use App\Http\Requests\subProductCategoriesRequest;
use App\Http\Services\CategoryService;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use App\Libraries\UploadImagesController;

class ProductCategoryController extends HomeController
{
    private $CategoryService;
 private  $MediaController;
    public function __construct(UploadImagesController $MediaController,CategoryService $CategoryService)
    {
        $this->CategoryService = $CategoryService;
        $this->MediaController  = $MediaController;
    }

    public function getProductsCategories($parent = null)
    {
        $data = $this->CategoryService->getAll($parent);
        return view('AdminPanel.PagesContent.ProductsCategories.index')->with('productsCategories',$data);
    }

    public function editProductsCategories(Category  $category)
    {
        return view('AdminPanel.PagesContent.ProductsCategories.edit')->with('category', $category);
    }

    public function updateProductsCategories(CategoriesRequest  $request, $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
             $validated['image'] = $this->MediaController->UploadImage($request['image'], 'images/categories');
         }
        $this->CategoryService->updateRow($validated , $id);
        return redirect()->back()->with('message','Spinner Updated Successfully');
    }

    public function storeProductsCategories(CategoriesRequest  $request)
    {
        $validated = $request->validated();
        $validated['parent_id'] = null;
        $validated['level'] = 1;
       if ($request->hasFile('image')) {
             $validated['image'] = $this->MediaController->UploadImage($request['image'], 'images/categories');
         }
        $this->CategoryService->createRow($validated);
        return redirect()->route('productsCategories.mainCategory')->with('message','Category Created Successfully');
    }

    public function createProductsCategories()
    {
        return view('AdminPanel.PagesContent.ProductsCategories.edit');
    }

    public function addProductsSubCategories()
    {
        $data = $this->CategoryService->getAll(null);
        return view('AdminPanel.PagesContent.ProductsCategories.subCategory')->with('productsCategories',$data);
    }

    public function getCteroires(Request  $request)
    {
        $id = $request->parent_id;
        $data = [];
        if (isset($id))
        $data = $this->CategoryService->getAllChild($id);
        return json_encode($data);
    }

    public function storeProductsSubCategories(Request  $request)
    {
        $validated = $request->except('_token');
         if ($request->hasFile('image')) {
             $validated['image'] = $this->MediaController->UploadImage($request['image'], 'images/categories');
         }
        $this->CategoryService->createSubCategoryRow($validated);
        return redirect()->back()->with('message','Category Created Successfully');
    }

    public function getSubProductsCategories()
    {
        $data = $this->CategoryService->getAllSubCategories();
        return view('AdminPanel.PagesContent.ProductsCategories.indexSubCategories')->with('productsCategories',$data);
    }

    public function editSubProductsCategories(Category  $category)
    {
//         $parents = $this->CategoryService->getMyParents($category);
        $parents=$this->CategoryService->getAll(null);
         return view('AdminPanel.PagesContent.ProductsCategories.editSubCategories',compact('category','parents'));
    }

    public function updateSubProductsCategories(subProductCategoriesRequest $request,$id)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
             $validated['image'] = $this->MediaController->UploadImage($request['image'], 'images/categories');
         }
        $this->CategoryService->updateSubProductsCategoriesRow($validated , $id);
        return redirect()->back()->with('message','Updated Successfully');
    }

    public function viewGraph(Category  $category)
    {
        $childs = $this->CategoryService->viewGraph($category);
        return view('AdminPanel.PagesContent.ProductsCategories.view',compact('category','childs'));
    }
    public function changeStatus(changeStatus $request,$id){
        $validated = $request->validated();
        $this->CategoryService->updateRow($validated , $id);
        $this->CategoryService->updateProducts($validated , $id);

        return redirect()->back()->with('message','Updated Successfully');

    }

    public function deleteCategoryProduct($id){
        $this->CategoryService->deleteCategoryProduct($id);
        return redirect()->back()->with('message','Deleted Successfully');
    }

    public function addCategoryProduct(AddCategoryProductRequest $request){
        $validated = $request->validated();
        $this->CategoryService->deleteCategoryProduct($validated['product_id']);

        $this->CategoryService->addCategoryProduct($validated);
//        $categories=collect($request->categories->toarray());
        return redirect()->back()->with('message','Added Successfully');


    }
    public function deleteProductsCategories(Category  $category){

        //get all products in this category

        $this->CategoryService->deleteAllProductsByCategory($category->id,$category->parent_id);
        // delete rows wich product and category ,product and subcategory
        // delete this category
        $this->CategoryService->delete($category->id);
                return redirect()->back()->with('message','Deleted  Successfully');

    }


}
