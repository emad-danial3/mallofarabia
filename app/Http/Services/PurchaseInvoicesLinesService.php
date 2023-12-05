<?php

namespace App\Http\Services;

use App\Http\Repositories\PurchaseInvoiceLinesRepository;

class PurchaseInvoicesLinesService extends BaseServiceController
{
    private  $PurchaseInvoiceLinesRepository;

    public function __construct(PurchaseInvoiceLinesRepository $PurchaseInvoiceLinesRepository)
    {
        $this->PurchaseInvoiceLinesRepository=$PurchaseInvoiceLinesRepository;
    }

    public function createInvoiceLines($product)
    {
           $this->PurchaseInvoiceLinesRepository->createLines($product);
    }
     public function getAll($inputData)
    {
        return $this->PurchaseInvoiceLinesRepository->getAllData($inputData);
    }

}
