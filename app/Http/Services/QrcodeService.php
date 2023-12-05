<?php

namespace App\Http\Services;

use App\Http\Repositories\IAccountTypeRepository;
use App\Http\Repositories\QrcodeRepository;

class QrcodeService extends BaseServiceController
{

    public  $QrcodeRepository;
    public  $accountTypeRepository;

    public function __construct(QrcodeRepository $QrcodeRepository,IAccountTypeRepository $accountType)
    {
        $this->QrcodeRepository = $QrcodeRepository;
        $this->accountTypeRepository = $accountType;
    }



}
