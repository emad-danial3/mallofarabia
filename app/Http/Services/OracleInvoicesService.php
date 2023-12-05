<?php

namespace App\Http\Services;

use App\Http\Repositories\OracleInvoiceRepository;

class OracleInvoicesService extends BaseServiceController
{
    private  $OracleInvoiceRepository;

    public function __construct(OracleInvoiceRepository  $OracleInvoiceRepository)
    {
        $this->OracleInvoiceRepository = $OracleInvoiceRepository;
    }

    public function getAll($inputData)
    {
        return $this->OracleInvoiceRepository->getAllData($inputData);
    }
    public function createOrUpdate($inputData)
    {
        return $this->OracleInvoiceRepository->updateOrCreate($inputData);
    }

    public function updateInvoices()
    {
        return $this->OracleInvoiceRepository->updateInvoices();
    }
    public function getOrdersNotSentToOracle()
    {
        return $this->OracleInvoiceRepository->getOrdersNotSentToOracle();
    }
    public function ordersCountSentToOracleNotReturn()
    {
        return $this->OracleInvoiceRepository->ordersCountSentToOracleNotReturn();
    }


    public function find($id)
    {
        return $this->OracleInvoiceRepository->find($id,['*']);
    }
}
