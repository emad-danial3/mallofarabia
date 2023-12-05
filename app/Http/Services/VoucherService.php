<?php

namespace App\Http\Services;

use App\Libraries\UploadImagesController;
use Khaleds\Voucher\Repositories\VoucherRepository;

class VoucherService extends BaseServiceController
{
    private $voucherRepository;
    private $MediaController;

    public function __construct(VoucherRepository  $voucherRepository,UploadImagesController $MediaController)
    {
        $this->voucherRepository = $voucherRepository;
        $this->MediaController = $MediaController;
    }

    public function getAll()
    {
        return $this->voucherRepository->getAll(['*']);
    }

    public function updateRow($updatedData , $id)
    {
        if (request()->has('image'))
            $updatedData['image'] = $this->MediaController->UploadImage($updatedData['image'] ,'images/vouchers');

        return  $this->voucherRepository->update( $updatedData,$id);
    }

    public function createRow($inputData)
    {
        $inputData['image'] = $this->MediaController->UploadImage($inputData['image'] ,'images/vouchers');

        return  $this->voucherRepository->create($inputData);
    }

}
