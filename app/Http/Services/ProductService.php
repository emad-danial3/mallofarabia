<?php

namespace App\Http\Services;

use App\Constants\OrderTypes;
use App\Constants\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoriesRepository;
use App\Http\Repositories\IProductRepository;
use App\Http\Repositories\IUserRepository;
use App\Http\Repositories\ProductCategoriesRepository;
use App\Http\Repositories\ProductRepository;
use App\Libraries\UploadImagesController;
use App\Models\OptionProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\OrderLinesRepository;

class ProductService extends BaseServiceController
{
    private $ProductRepository;
    private $MediaController;
    private $CategoriesRepository;
    private $ProductCategoriesRepository;
    private $OrderLinesRepository;

    public function __construct(ProductRepository           $ProductRepository,
                                UploadImagesController      $MediaController,
                                CategoriesRepository        $CategoriesRepository,
                                OrderLinesRepository        $OrderLinesRepository,
                                ProductCategoriesRepository $ProductCategoriesRepository)
    {
        $this->ProductRepository           = $ProductRepository;
        $this->MediaController             = $MediaController;
        $this->CategoriesRepository        = $CategoriesRepository;
        $this->OrderLinesRepository        = $OrderLinesRepository;
        $this->ProductCategoriesRepository = $ProductCategoriesRepository;
    }

    public function getAllProducts($inputData)
    {
        return $this->ProductRepository->getAllProducts($inputData, 0);
    }
    public function getBestProducts($inputData)
    {
        return $this->ProductRepository->getBestProducts($inputData, 0);
    }

    public function getNextOffset()
    {
        return $this->ProductRepository->nextOffset();
    }

    public function getAllCompanyProducts($company_id)
    {
        return $this->ProductRepository->getAll(['id', 'name_ar'], ['flag' => $company_id]);
    }

    public function getAll($inputData)
    {
        return $this->ProductRepository->getAllData($inputData);
    }

    public function updateRow($updatedData, $id)
    {
        if (isset($updatedData['image'])) {
            $updatedData['image'] = $this->MediaController->UploadImage($updatedData['image'], 'images');
        }
        return $this->ProductRepository->updateData(['id' => $id], $updatedData);
    }

    public function updateOrderProductQuntity($orderId)
    {
        $OrderLines = $this->OrderLinesRepository->getOrderLines($orderId);
        if (isset($OrderLines) && count($OrderLines) > 0) {
            for ($i = 0; $i < count($OrderLines); $i++) {
                $product = $this->ProductRepository->find($OrderLines[$i]->product_id, ['id', 'quantity', 'stock_status']);
                if (!empty($product)) {
                    $quantity = intval($product->quantity) - intval($OrderLines[$i]->quantity);
                    $data     = ['quantity' => $quantity];
                    if ($quantity < 1) {
                        $data = ['quantity' => $quantity, 'stock_status' => 'out stock'];
                    }
                    $this->ProductRepository->updateData(['id' => $product->id], $data);
                }
            }
        }

        return true;
    }

    public function createRow($inputData)
    {

        if (isset($inputData['image']))
            $inputData['image'] = $this->MediaController->UploadImage($inputData['image'], 'images');

        $product_id = $this->ProductRepository->createProduct([
            "full_name"            => $inputData['full_name'],
            "flag"                 => $inputData['flag'],
            "name_ar"              => $inputData['name_ar'],
            "name_en"              => $inputData['name_en'],
            "price"                => $inputData['price'],
            "tax"                  => $inputData['tax'],
            "discount_rate"        => $inputData['discount_rate'],
            "price_after_discount" => $inputData['price'] - (($inputData['price'] * $inputData['discount_rate']) / 100),
            "quantity"             => $inputData['quantity'],
            "weight"               => $inputData['weight'],
            "description_ar"       => $inputData['description_ar'],
            "description_en"       => $inputData['description_en'],
            "oracle_short_code"    => $inputData['oracle_short_code'],
            "image"                => $inputData['image'],
            "filter_id"            => $inputData['filter_id'],
            "barcode"              => $inputData['barcode'],
            "old_price"            => $inputData['old_price'],
            "old_discount"            =>  round((((float)($inputData['old_price'] - (float)$inputData['price']) /(float)$inputData['old_price'])*100),2),
        ]);

        if ($inputData['category_id']) {
            $categoriesList    = [];
            $category          = $this->CategoriesRepository->find($inputData['category_id']);
            $categoriesList [] = $category;
            for ($i = 0; $i < $category['level']; $i++) {

                if ($categoriesList[$i]['id']) {
                    $categoriesList [] = $this->CategoriesRepository->find($categoriesList[$i]['parent_id']);
                    $this->ProductCategoriesRepository->create(
                        [
                            "product_id"  => $product_id,
                            "category_id" => $categoriesList[$i]['id']
                        ]);

                }

            }

        }

        if (isset($inputData['options'])&& count($inputData['options']) > 0) {
            for ($ii = 0; $ii < count($inputData['options']); $ii++) {
                if ($inputData['options'][$ii] && $inputData['optionValues'][$ii] && $inputData['optionQuantity'][$ii] && $inputData['optionPrice'][$ii]) {
                    OptionProduct::create(
                        [
                            "product_id"      => $product_id,
                            "option_id"       => $inputData['options'][$ii],
                            "option_value_id" => $inputData['optionValues'][$ii],
                            "quantity"        => $inputData['optionQuantity'][$ii],
                            "price"           => $inputData['optionPrice'][$ii],
                        ]);
                }
            }
        }
    }

    public function changeStatus($product_ids, $status)
    {
        return $this->ProductRepository->changeStatus($product_ids, $status);
    }

}
