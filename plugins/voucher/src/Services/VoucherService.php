<?php

namespace Khaleds\Voucher\Services;

use Khaleds\Voucher\Classes\VoucherMinimum50;
use Khaleds\Voucher\Models\UserVoucher;
use Khaleds\Voucher\Models\Voucher;
use Khaleds\Voucher\Repositories\VoucherRepository;

class VoucherService
{

    private static $voucherRepository;
    public function __construct(VoucherRepository $voucherRepository)
    {
        VoucherService::$voucherRepository=$voucherRepository;
    }


    public static function check(&$userObject,$user_id)
    {

//        $vouchers=VoucherService::$voucherRepository->getAll(['*'],[['is_available','=',1],['expires_at','>=',now()]]);

        // close voucher make all usersed that only applied un used
        //move it to repo
            $vouchers = Voucher::where('is_available', 1)
                ->where('expires_at', '>=', now())
                ->with(['Users' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);

                }])
                ->first();

            // for now we have only one record
            if (!empty($vouchers) && isset($vouchers->Users->status)) {

                if ($vouchers->Users->status == 'Applied') {
                    $voucher = new VoucherMinimum50();
                    $voucher->amount = $vouchers->discount_amount;
                    $voucher->oldMinimum = $userObject['services']['min_required'];
                    $voucher->type = $vouchers->type;
                    $voucher->apply();

                    $userObject['services']['min_required'] = $voucher->newMinimum;

                }


            } elseif (!empty($vouchers) && !isset($vouchers->Users->status)) {

                $userObject['vouchers'] = $vouchers->only(['name', 'description', 'image']);
            }

    }

    public static function changeStatus($status,$user_id){

        UserVoucher::where('user_id',$user_id)->update(['status'=>$status]);
    }

}
