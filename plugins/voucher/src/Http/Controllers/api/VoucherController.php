<?php

namespace Khaleds\Voucher\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use Illuminate\Http\Request;
use Khaleds\Voucher\Http\Requests\Voucher\SetVoucherRequest;
use Khaleds\Voucher\Models\UserVoucher;
use Khaleds\Voucher\Models\Voucher;

class VoucherController extends Controller
{
    //check if there is many users
    //check for renew voucher

    private $API_RESPONSE;

    public function __construct(ApiResponse  $API_RESPONSE)
    {
        $this->API_RESPONSE             = $API_RESPONSE;

    }

    public function setVoucher(SetVoucherRequest $request){

        $validated=$request->validated();

        $user_id=request()->user_id;

        //check for max user number
        //move it to repo
        $voucher=Voucher::where('is_available',1)
            ->where('expires_at','>=',now())
            ->where('code',$validated['code'])
            ->with(['Users' => function($query) use ($user_id)
            {
                $query->where('user_id',$user_id);

            }])
            ->first();

        if (!isset($voucher->Users->status) ) {

            UserVoucher::create([
                'user_id' => $user_id,
                'voucher_id' => $voucher->id
            ]);

            $voucher->increment('uses');
            $voucher->save();
        }
        else
            return $this->API_RESPONSE->errors(['this voucher is used before'],400);


        return  $this->API_RESPONSE->success('Happy Voucher :)',200);

        //code and user id**
        //check if this voucher assigned before for this user or not **
        //if assigned return false **
        //if false set this user in user_voucher table **
        //increse users **
        //check for max uses and max uses per user
        //check for starts at and expires at **
        //ahmed should call user info to get new data


        //event for set promo code to used
    }
}
