<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Services\QrcodeService;
use App\Libraries\ApiResponse;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    //
    private $qrcodeService;
    public function __construct(QrcodeService $qrcodeService)
    {
        $this->qrcodeService=$qrcodeService;
    }


    public function check(Request  $request){

        if(isset($request['code']) && isset($request['type'])){
            $codes=$this->qrcodeService->QrcodeRepository->getAll(['*'],
                ['is_available'=>1,['end_date','>=',now()],
                    ['start_date','<=',now()],
                    'code'=>$request['code'],'account_type'=>$request['type']]);


            if (count($codes) >= 1){

                $codes->first()->increment('uses',1);
                $codes->first()->save();
                return ApiResponse::success('Happy Voucher :) ',200);

            }

            return ApiResponse::errors(['This code not found or finished'],404);
        }
        return ApiResponse::errors(['This code not found or finished'],400);

    }
}
