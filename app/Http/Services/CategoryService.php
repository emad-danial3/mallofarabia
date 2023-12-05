<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoriesRepository;
use App\Http\Repositories\IProductCategoriesRepository;
use App\Http\Repositories\IProductRepository;


class CategoryService extends BaseServiceController
{

    private  $CategoriesRepository;
    private  $productRepository;
    private  $productCategoriesRepository;


    public function __construct( CategoriesRepository  $CategoriesRepository,IProductRepository $productRepository,IProductCategoriesRepository $productCategoriesRepository)
    {
        $this->CategoriesRepository = $CategoriesRepository;
        $this->productRepository = $productRepository;
        $this->productCategoriesRepository = $productCategoriesRepository;


    }

    public function getAll($parent_id)
    {
        return $this->CategoriesRepository->getAll(['*'],['parent_id' => $parent_id]);
    }

    public function updateRow($updatedData , $id)
    {
        return  $this->CategoriesRepository->updateData(['id' => $id] ,$updatedData);
    }

    public function createRow($inputData)
    {
        return  $this->CategoriesRepository->create($inputData);
    }

    public function getAllChild($parent_id)
    {
          return $this->getMyChild($parent_id);
    }

    private function getMyChild($parent_id)
    {
        $childReturn = $this->CategoriesRepository->getMychild($parent_id);
        foreach ($childReturn as $child)
        {
            $childs =$this->CategoriesRepository->getMychild($child['id']);
            if (count($childs) > 0)
            {
                foreach ($childs as $sub)
                {
                    $childReturn [] = $sub;
                }
            }

        }
        return $childReturn;
    }

    public function createSubCategoryRow($inputData)
    {


        if (isset($inputData['child_id']))
        {
            $child = $this->CategoriesRepository->find($inputData['child_id']);
            $insertedSubCategoryData =  [
              "name_en" => $inputData['name_en'],
              "name_ar" => $inputData['name_ar'],
              "parent_id" => $inputData['child_id'],
              "level" => $child['level'] +1,
            ];
            return  $this->CategoriesRepository->create($insertedSubCategoryData);
        }
        else
        {
            $inputData['level'] = 2;
            return  $this->CategoriesRepository->create($inputData);
        }

    }

    public function getAllSubCategories()
    {
        return $this->CategoriesRepository->getAllSubCategories();
    }

    public function getMyParents($category)
    {
      $returnedCategories = [$category];
      for ($i =0 ;$i < $category['level'];$i++)
      {
          if ($returnedCategories[$i]['parent_id'])
              $returnedCategories [] = $this->CategoriesRepository->find($returnedCategories[$i]['parent_id']);
      }
       return $returnedCategories;
    }

    public function updateSubProductsCategoriesRow($updatedData,$id)
    {
        $oldCategoryData = $this->CategoriesRepository->find($id);

        if ($oldCategoryData['parent_id'] == $updatedData['parent_id'])
        {
            return  $this->CategoriesRepository->updateData(['id' => $id] ,$updatedData);
        }
        else
        {
            //remove all products from products categories with old parent
            $productIds=$this->findProductsIds($id);
            $this->productCategoriesRepository->deleteChunk($productIds,$oldCategoryData['parent_id']);
            $this->productCategoriesRepository->insertChunk($productIds,$updatedData['parent_id']);

            //add all this products to the new parent
           $myNewParentData = $this->CategoriesRepository->find($updatedData['parent_id']);

           $myNewLevel = $myNewParentData['level'] + 1 ;
            $updatedData['level'] = $myNewLevel;
            $myChilds = $this->getMyChild($id);

            foreach ($myChilds as $child)
            {

                $myNewLevel+=1;
                $this->CategoriesRepository->updateData(['id'=> $child['id']] , ['level' => $myNewLevel]);
            }
           $this->CategoriesRepository->updateData(['id'=> $id] , $updatedData);
        }
    }

    public function viewGraph($category)
    {
      return $this->getMyChild($category['id']);
    }


    public function updateProducts($updatedData , $id){
        $productIds=$this->CategoriesRepository->find($id,['id','parent_id'],['Products']);
        $collection = collect($productIds->Products);
        $Ids = $collection->map(function ($item, $key) {return $item->id;});

        if ($updatedData['is_available']==0){
            $this->productRepository->changeStatus($Ids->all(),'out stock');
        }else{
            $this->productRepository->changeStatus($Ids->all(),'in stock');
        }

        }
        private function findProductsIds($id){
            $productIds=$this->CategoriesRepository->find($id,['id','parent_id'],['Products']);
            $collection = collect($productIds->Products);
            $Ids =  $collection->map(function ($item, $key) {return $item->id;});

            return $Ids;
        }

        public function deleteCategoryProduct($id){

        //oldCode
//            $this->productCategoriesRepository->delete($id);

            $data=$this->productCategoriesRepository->getAll(['id'],['product_id'=>$id]);
            if ($data && count($data) > 0)
            $data->each->delete();
    }

        public function addCategoryProduct($inputData){

                $categoriesList=[];
                $category = $this->CategoriesRepository->find($inputData['category_id']);
                $categoriesList []= $category;
                for ($i = 0 ; $i < $category['level'] ; $i++ )
                {

                    if ($categoriesList[$i]['id'])
                    {
                        $categoriesList [] = $this->CategoriesRepository->find($categoriesList[$i]['parent_id']);
                        $this->productCategoriesRepository->create(
                            [
                                "product_id" => $inputData['product_id'],
                                "category_id" => $categoriesList[$i]['id']
                            ]);

                    }

                }

            }


        public function deleteAllProductsByCategory($categoryId,$parentId){

            $productIds=$this->findProductsIds($categoryId);
            $this->productCategoriesRepository->deleteChunk($productIds,$categoryId);
            $this->productCategoriesRepository->deleteChunk($productIds,$parentId);

    }

    public function delete($categoryId){
        $this->CategoriesRepository->delete($categoryId);

    }



}
