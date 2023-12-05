<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Services\PaidOrderActions\MainPaidActions;
use App\Models\OrderHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TestingOracleController extends Controller
{
    //
    private $UserRepository;
    private $catch='no catch ';
    private $response;
    private $OrderRepository;
    public function __construct(UserRepository $UserRepository,OrderRepository $order)
    {
        $this->UserRepository=$UserRepository;
        $this->OrderRepository=$order;
    }

    public function sendUser(Request $request){

            $user_id=$request->input('user_id');
            $userRow = $this->UserRepository->find($user_id,['account_id','full_name','phone','nationality_id','address']);
            // send User To Guzzle
            try {
                $client = new \GuzzleHttp\Client();
                $data=[
                    'account_id'      =>  $userRow->account_id,
                    'full_name'       =>  $userRow->full_name,
                    'mobile'          =>  $userRow->phone,
                    'nationality_id'  =>  $userRow->nationality_id,
                    'address'         =>  $this->faTOen($userRow->address)??"9 El sharekat, Opera",
                ];
                  $this->response=  $client->request('POST','https://sales.atr-eg.com/api/save_user_nettinghub_4u.php',['form_params'=>$data ,'verify' => false])->getBody()->getContents();
                  Log::info($this->response);
            }catch (\Exception $e){
             $this->catch=$e->getMessage();
                Log::error('sending USER to oracle USER_ID :: '.$user_id.' ERROR::'.$e->getMessage());
            }

    return response()->json([json_decode($this->response),json_decode($this->catch)]);
    }
    public function sendOrder(Request $request)
    {

        $order_id=$request->input('order_id');
        $user_id=OrderHeader::where('id',$order_id)->first()['user_id'];
        $OrderLines = $this->OrderRepository->getOrder($order_id);
        $newValue=[];
        $paymentCode=[];
        $max=0;
//        return $OrderLines;
        foreach ($OrderLines as $orderLine)
        {

            if (!array_key_exists($orderLine->payment_code, $paymentCode)) {
                $max  += 1;
                $OrderTypesArray[$orderLine->payment_code] = $max;
            }
            else {
                $orderLine->has_free_product = 0;
            }
            $newValue[]= $orderLine;

        }
//        return $newValue;
        try {

//            dd($newValue);

//            $client = new \GuzzleHttp\Client();
//            $this->response=  $client->request('POST','https://sales.atr-eg.com/api/save_order_nettinghub4u.php',[
//                'form_params'=>[
//                    'order_lines'=>$newValue
//                ],'verify' => false]);
//            Log::info($this->response->getBody()->getContents());
//            if($this->response->getStatusCode() == 200){
//                $updateOrder= OrderHeader::where('id',$order_id)->first();
//                if($updateOrder){
//                    $updateOrder->send_t_o='1';
//                    $updateOrder->save();
//                }
//            }
        }catch (\Exception $e){
            $this->catch=$e->getMessage();
            Log::error('sending ORDER to oracle ERROR::'.$e->getMessage());
            $code=$e->getCode();
            if($code==503){
                $userRow = $this->UserRepository->find($user_id,['account_id','full_name','phone','nationality_id','address']);
                    $client = new \GuzzleHttp\Client();
                    $data=[
                        'account_id'      => $userRow->account_id,
                        'full_name'       =>  $userRow->full_name,
                        'mobile'          =>  $userRow->phone,
                        'nationality_id'  =>  $userRow->nationality_id,
                        'address'         =>  $this->faTOen($userRow->address)??"9 El sharekat, Opera",
                    ];
                    $this->response=  $client->request('POST','https://sales.atr-eg.com/api/save_user_nettinghub_4u.php',['form_params'=>$data ,'verify' => false])->getBody()->getContents();
                Log::info($this->response);
            }

        }
        return response()->json(['response'=>$this->response,'catch'=>$this->catch,'object'=>$newValue]);

    }

    public function ProductImages(ProductImagesRequest $request){

         $request->validated();
    return 'i am in function';
    }

    public function changePassword(Request $request){

        return Hash::make($request->password);
    }
 public function faTOen($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }

}
