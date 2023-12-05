<?php

namespace App\Http\Controllers\Website;
use App\Constants\OrderStatus;
use App\Constants\PaymentNames;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderLinesService;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentService;

use App\Models\Category;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\Product;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;
use App\Models\User;
use App\Models\Cart;

use Illuminate\Support\Facades\Log;
use Session;




class CartController extends Controller
{
    private  $PaymentService;
    private  $OrderService;

    public function __construct(
        PaymentService $PaymentService,
        OrderService $OrderService)
    {

        $this->PaymentService          = $PaymentService;
        $this->OrderService            = $OrderService;
    }

    public function shop($id=null)
    {


        $products = Product::where('stock_status','in stock')->get();
        //khaled
        $product = Category::distinct()->get(['name_en','id']);



        return view('shop')->withTitle('Netting Hub | SHOP')->with(['products' => $products,'product'=>$product]);
    }





    public function shoppost(Request $request)
    {



    }

    public function cart($id=null)  {

        $cartCollection = \Cart::getContent();

        return view('cart')->withTitle('E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection]);


    }

    public function search(Request $request){


        $cat=$request->cat;


        if($cat=='all'){
            $products = Product::where('stock_status','in stock')->get();
        }else{

            $products=Product::
            where('products.stock_status','in stock')->
            where('products.visible_status','visible_status');

            $products->join('product_categories','product_categories.product_id' ,'products.id')
                ->where('product_categories.category_id',$cat);

//            $products = Product::where('brand',$cat)->where('stock_status','in stock')->get();
            $products=$products->get();

        }

        $product = Category::distinct()->get(['name_en','id']);


        return view('shop', compact('products','product'));

    }


    public function saveProductToCart(Request $request){
        if($request->quantity==0){
        $response = [
            'status' => 400,
            'message' => "quantity = 0",
            'data' => null
        ];
        return response()->json($response);
        }else{
            \Cart::add(array(
                'id' => $request->id,
                'name' => $request->sku,
                'oracle_short_code'=>$request->oracle_short_code,
                'price' => $request->price,
                'flag' => $request->flag,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'image' => $request->image,
                    'sku' => $request->sku
                )
            ));
        }

        return redirect('shop/#'.$request->id.'')->with('success_msg', 'Item is Added to Cart!');
    }

    public function add(Request$request){
        if($request->quantity==0){

        }else{
            \Cart::add(array(
                'id' => $request->id,
                'name' => $request->sku,
                'oracle_short_code'=>$request->oracle_short_code,
                'price' => $request->price,
                'flag' => $request->flag,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'image' => $request->image,
                    'sku' => $request->sku
                )
            ));
        }

        return redirect('shop/#'.$request->id.'')->with('success_msg', 'Item is Added to Cart!');
    }

    public function remove(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    public function update(Request $request){

        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->input('quantity')
                ),
            ));
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    public function clear(){
        \Cart::clear();
        return redirect()->back()->with('success_msg', 'Cart is cleared!');
    }

    public function fawry(){
        $user_id = 1;
        $order_header=OrderHeader::select('id','total_order')->where('user_id',$user_id)->latest()->first();
        $order=DB::select('SELECT
       p.name_en as psku,p.description_en as pdescription,ol.price as olprice,ol.quantity as olquantity,
       ol.product_id as olitemcode,p.image as pimage , ol.order_id as olorder_num
FROM order_lines ol , products p
                              WHERE ol.product_id=p.id and ol.order_id='.$order_header->id.'

	                      ');
        $total_order=$order_header->total_order;
        $user=DB::table('users')->where('id',$user_id)->first();

        // orders items
        // sort items
       $pprice = $total_order < 225 ? 25.0 : 0.0;
        array_push($order, (object)['olitemcode' => $order_header->id, 'psku' => '', 'olprice' => $pprice, 'olquantity' => 1, 'pimage' => '', 'olorder_num' => $order_header->id]);
        foreach ($order as $orderrhh) {
            $orderrhh->olitemcode= strval($orderrhh->olitemcode);
        }

        usort($order, function($a, $b) {return strcmp($a->olitemcode, $b->olitemcode);});

//        usort($order,function($first,$second){
//            return $first->olitemcode > $second->olitemcode;
//        });

        if(count($order)>0) {
            $itm = '';
            foreach ($order as $orderr) {
                $itm .= $orderr->olitemcode . $orderr->olquantity .number_format((float)$orderr->olprice, 2, '.', '');
            }
        }
//        $merchantCode    = '1tSa6uxz2nQFNIFa9AHjDA=='; // testing
        $merchantCode    = 'TWp4BK7owYobL082js6IXg=='; // live
        $merchantRefNum  = $order_header->id;
        $amount=$order_header->total_order;
        $customerProfileId=$user->account_id;
//        $merchant_sec_key =  'b560c6003c9a4f95b963a7f3c965e24c'; // For the sake of demonstration testing
        $merchant_sec_key =  'a4a4860d4df64eec90f4937dcbfa44c1'; // For the sake of demonstration live
        $returnUrl='https://4unettinghub.com/fawry2?id='.$user->id;

        $fsbh=$merchantCode.$merchantRefNum.$customerProfileId.$returnUrl.$itm.$merchant_sec_key;
        $signature = hash('sha256' , $fsbh);

      return view('fawry',compact('order','user','total_order','merchantCode','merchantRefNum','signature','amount','returnUrl'));
}


    private function GenerateOrcalNumber($max)
    {
        // start oracle Number
        $maxnum=$max;
        $useroracle_num=10241;
        $date=date("dmy");
        if(strlen((string)$maxnum)==2)
        {
            $maxnum1='000'.$maxnum;
        }elseif(strlen((string)$maxnum)==3){
            $maxnum1='00'.$maxnum;
        }elseif(strlen((string)$maxnum)==4){
            $maxnum1='0'.$maxnum;
        }else{
            $maxnum1=$maxnum;
        }
        $oracle_num=$useroracle_num.$date.'-'.$maxnum1;
        return $oracle_num;
    }


    public function createOrderHeader($orderData, $address)
    {

        $orderHeaderData = [
            'payment_code'          => (isset($orderData['payment_code']))?$orderData['payment_code'] : NULL,
            'total_order'         => $orderData['total'],
            'user_id'             => $orderData['user_id'],
            'created_for_user_id' => $orderData['created_for_user_id'],
            'order_type'          => $orderData['order_type'],
            'shipping_amount'     => $orderData['shipping_amount'],
            'address'             => $address['address'],
            'city'                => $address['city'],
            'area'                => $address['area'],
            'building_number'     => $address['building_number'],
            'landmark'            => $address['landmark'],
            'floor_number'        => $address['floor_number'],
            'apartment_number'    => $address['apartment_number'],
            'gift_category_id'    => $orderData['gift_category_id']
        ];
        $orderHeaderData['id'] = $this->OrderRepository->createOrder($orderHeaderData);

        return $orderHeaderData ;


    }


    public function newProceed(){
        $id                  = Input::get('id');
        $price               = Input::get('price');
        $quantity            = Input::get('quantity');
        $oracle_short_code   = Input::get('oracle_short_code');
        $total               = Input::get('total');

        $user_id             = Auth::user()->id;


        $user=DB::table('users')->where('id',$user_id)->first();

        if($user->account_type==1){
            if($total<1500){

                return redirect()->route('cart.index')->with('error_msg', 'Error Minmum Must be 1500 !');
            }else{

                $level=DB::table('account_levels')->where('level',1)->where('child_id',$user_id)->first();
                $created_by=$level->parent_id;// parent id
                $created_for=$user_id;// this id child id

                $orderHeaderData = [
                    'payment_code'          => (isset($orderData['payment_code']))?$orderData['payment_code'] : NULL,
                    'total_order'         => $total,
                    'user_id'             => $created_for,
                    'created_for_user_id' => $created_by,
                    'order_type'          => 'create_user',
                    'shipping_amount'     => 75,
                    'address'             => $user->address,
                    'city'                => $user->city,
                    'area'                => $user->area,
                    'building_number'     => $user->building_number,
                    'landmark'            => $user->landmark,
                    'floor_number'        => $user->floor_number,
                    'apartment_number'    => $user->apartment_number,
                ];
                OrderHeader::create($orderHeaderData);
                $lastId= \Illuminate\Support\Facades\DB::getPdo()->lastInsertId();
                $order_lines=OrderLine::select('id','max')->orderBy('id', 'desc')->first();
                $max= (isset($order_lines))? $order_lines->max : 0;

                $OrderLinesService= new OrderLinesService();
                $CommissionService= new CommissionService();
                $OrderLinesService->createOrderLines($orderHeaderData['id'] , $created_for, $created_by);
                $CommissionService->createCommission($orderHeaderData);


            }
        }
    }
    function proceed (Request $request)
    {

//dd($request->all());
        $id                  = $request->input('id');
        $price               = $request->input('price');
        $quantity            = $request->input('quantity');
        $oracle_short_code   = $request->input('oracle_short_code');
        $total               = $request->input('total');
        $flag=$request->input('flag');

        $user_id             = Auth::user()->id;


        $user=DB::table('users')->where('id',$user_id)->first();

        if($user->account_type==1){
            if($total<1500){

                return redirect()->route('cart.index')->with('error_msg', 'Error Minmum Must be 1500 !');
            }

            else{


                $level=DB::table('account_levels')->where('level',1)->where('child_id',$user_id)->first();
                date_default_timezone_set('Africa/Cairo');
                $date=date("dmy");
                $fourRandomDigit = mt_rand(1000,9999);
                $order_num=$date.$user_id.$fourRandomDigit;
                $created_by=$level->parent_id;
                $created_for=$user_id;
                $address=$user->address;
                $city=$user->city;
                $area=$user->area;
                $building_number=$user->building_number;
                $floor_number=$user->floor_number;
                $apartment_number=$user->apartment_number;
                $landmark=$user->landmark;

                /**/
                $max=DB::table('order_lines')->orderBy('id', 'desc')->first();
                $max=$max->max;
                $OrderTypesArray=[];


//                $deletedRows = DB::table('order_headers')->where('created_for', $created_for)->delete();
//                $deletedRows = DB::table('order_lines')->where('created_for', $created_for)->delete();


                DB::table('users')->where('id', $created_for)->update(['stage' => 2]);
                $order=DB::table('order_headers')->insertGetId([
//                    'order_num'           => $order_num,
                    'total_order'         => $total,
                    'user_id'             => $created_by,
                    'created_for_user_id'         => $created_for,
                    'order_type'           =>  'create_user',
                    'address'             => $address,
                    'city'                => $city,
                    'area'                => $area,
                    'building_number'     =>$building_number,
                    'floor_number'        =>$floor_number,
                    'apartment_number'    =>$apartment_number,
                    'landmark'            =>$landmark,
//                    'max'                 =>$max,
                    'payment_status'       => 'PENDING',
                    'shipping_amount'   => 75,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('user_commissions')->where('commission_by', $created_for)
                    ->update([
                        'order_id' => $order,
//                          'total_number'=>$total

                    ]);

                foreach($id as $key => $id )
                {
                    if (!array_key_exists($flag[$key],$OrderTypesArray))
                    {
                        $max+=1;
                        $OrderTypesArray[$flag[$key]]=$this->GenerateOrcalNumber($max);
                    }

                    $arrData[] = array(
                        "order_id"   => $order,
                        "product_id"   => $id,
                        "oracle_num"   =>$OrderTypesArray[$flag[$key]],
                        "price"       => $price[$key],
                        "quantity"    => $quantity[$key],
                        "max"  => $max,
//                        "created_by"  => $created_by,
//                        "created_for" => $created_for,

                    );
                }


                DB::table('order_lines')->insert( $arrData );
                return redirect()->route('fawry');


            }

        }

        if($user->account_type==2){
            if($total<1000){
                return redirect()->route('cart.index')->with('error_msg', 'Error Minmum Must be 1000 !');
            }
            else{

                $level=DB::table('account_levels')->where('level',1)->where('child_id',$user_id)->first();
                date_default_timezone_set('Africa/Cairo');
                $date=date("dmy");
                $fourRandomDigit = mt_rand(1000,9999);
                $order_num=$date.$user_id.$fourRandomDigit;
                $created_by=$level->parent_id;
                $created_for=$user_id;
                $address=$user->address;
                $city=$user->city;
                $area=$user->area;
                $building_number=$user->building_number;
                $floor_number=$user->floor_number;
                $apartment_number=$user->apartment_number;
                $landmark=$user->landmark;

                /**/
                $max=DB::table('order_lines')->orderBy('id', 'desc')->first();
                $max=$max->max;
                $OrderTypesArray=[];


//                $deletedRows = DB::table('order_headers')->where('created_for', $created_for)->delete();
//                $deletedRows = DB::table('order_lines')->where('created_for', $created_for)->delete();


                DB::table('users')->where('id', $created_for)->update(['stage' => 2]);
                $order=DB::table('order_headers')->insertGetId([
//                    'order_num'           => $order_num,
                    'total_order'         => $total,
                    'user_id'             => $created_by,
                    'created_for_user_id'         => $created_for,
                    'order_type'           =>  'create_user',
                    'address'             => $address,
                    'city'                => $city,
                    'area'                => $area,
                    'building_number'     =>$building_number,
                    'floor_number'        =>$floor_number,
                    'apartment_number'    =>$apartment_number,
                    'landmark'            =>$landmark,
//                    'max'                 =>$max,
                    'payment_status'       => 'PENDING',
                    'shipping_amount'   => 50
                ]);

                DB::table('user_commissions')->where('commission_by', $created_for)
                    ->update([
                        'order_id' => $order,
//                          'total_number'=>$total

                    ]);

                foreach($id as $key => $id )
                {
                    if (!array_key_exists($flag[$key],$OrderTypesArray))
                    {
                        $max+=1;
                        $OrderTypesArray[$flag[$key]]=$this->GenerateOrcalNumber($max);
                    }

                    $arrData[] = array(
                        "order_id"   => $order,
                        "product_id"   => $id,
                        "oracle_num"   =>$OrderTypesArray[$flag[$key]],
                        "price"       => $price[$key],
                        "quantity"    => $quantity[$key],
                        "max"  => $max,
//                        "created_by"  => $created_by,
//                        "created_for" => $created_for,

                    );
                }


                DB::table('order_lines')->insert( $arrData );
                return redirect()->route('fawry');


            }

        }


        if($user->account_type==3){
            if($total<500){
                return redirect()->route('cart.index')->with('error_msg', 'Error Minmum Must be 500 !');
            }
            else{


                $level=DB::table('account_levels')->where('level',1)->where('child_id',$user_id)->first();
                date_default_timezone_set('Africa/Cairo');
                $date=date("dmy");
                $fourRandomDigit = mt_rand(1000,9999);
                $order_num=$date.$user_id.$fourRandomDigit;
                $created_by=$level->parent_id;
                $created_for=$user_id;
                $address=$user->address;
                $city=$user->city;
                $area=$user->area;
                $building_number=$user->building_number;
                $floor_number=$user->floor_number;
                $apartment_number=$user->apartment_number;
                $landmark=$user->landmark;

                /**/
                $max=DB::table('order_lines')->orderBy('id', 'desc')->first();
                $max=$max->max;
                $OrderTypesArray=[];


//                $deletedRows = DB::table('order_headers')->where('created_for', $created_for)->delete();
//                $deletedRows = DB::table('order_lines')->where('created_for', $created_for)->delete();


                DB::table('users')->where('id', $created_for)->update(['stage' => 2]);
                $order=DB::table('order_headers')->insertGetId([
//                    'order_num'           => $order_num,
                    'total_order'         => $total,
                    'user_id'             => $created_by,
                    'created_for_user_id'         => $created_for,
                    'order_type'           =>  'create_user',
                    'address'             => $address,
                    'city'                => $city,
                    'area'                => $area,
                    'building_number'     =>$building_number,
                    'floor_number'        =>$floor_number,
                    'apartment_number'    =>$apartment_number,
                    'landmark'            =>$landmark,
//                    'max'                 =>$max,
                    'payment_status'       => 'PENDING',
                    'shipping_amount'   => 50
                ]);

                DB::table('user_commissions')->where('commission_by', $created_for)
                    ->update([
                        'order_id' => $order,
//                          'total_number'=>$total

                    ]);

                foreach($id as $key => $id )
                {
                    if (!array_key_exists($flag[$key],$OrderTypesArray))
                    {
                        $max+=1;
                        $OrderTypesArray[$flag[$key]]=$this->GenerateOrcalNumber($max);
                    }

                    $arrData[] = array(
                        "order_id"   => $order,
                        "product_id"   => $id,
                        "oracle_num"   =>$OrderTypesArray[$flag[$key]],
                        "price"       => $price[$key],
                        "quantity"    => $quantity[$key],
                        "max"  => $max,
//                        "created_by"  => $created_by,
//                        "created_for" => $created_for,

                    );
                }


                DB::table('order_lines')->insert( $arrData );
                return redirect()->route('fawry');

//                $uemail=User::where('id',$created_by)->first();
//
//                $email=$uemail->email;
//                $femail=$uemail->full_name;
//
//                $fname=User::where('id',$created_for)->first();
//
//                $full_name=$fname->full_name;
//
//
//                require'muser/public/mailSender3.php';
//                $mail->setFrom('info@nettinghub.com', 'Netting Hub');
//                $mail->CharSet = 'UTF-8';
//
//
//                $mail->addAddress($email, '');
//                // Add a recipient
//                //$mail->addAddress('ellen@example.com');               // Name is optional
//                //$mail->addReplyTo('kyrellous.sherif@armaniousgroup.com', 'kyrellous shereif');
//                //$mail->addBCC('kyrellous.sherif@armaniousgroup.com');
//                //$mail->addCC('bcc@example.com');
//
//                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//                $mail->isHTML(true);                                  // Set email format to HTML
//
//                $mail->Subject = 'Commission mail';
//                $mail->Body  = "
//<html>
//<head>
//</head>
//<body>
//<img style='width:20%;' src='http://nettinghub.com/logo2.png' alt='Italian Trulli'>
//
//<h1 style='color:rgb(0, 148, 167);  text-align: center;'> Congratulation $femail </h1>
//
//<h3 style='color:rgb(0, 148, 167);  text-align: center;'>$full_name now joining as a Golden member on your Team!</h3>
//
//<h3 style='color:rgb(0, 148, 167);  text-align: center;'>Check your commission</h3>
//
//
//<p style='text-align: center;font-size:16px;color:rgb(0, 148, 167);'>If you have any questions, contact us at <a style='color:rgb(0, 148, 167);'  href = 'mailto: info@nettinghub.com'> info@nettinghub.com</a></p>
//
//
//<p style='text-align: center;font-size:10px;color:rgb(0, 148, 167);'>This message is from a notification-only address. Please do not reply to this email</p>
//
//
//
//
//</body>
//</html>
//";




            }
        }
    }


    public function fawry2(){

        if($_GET['statusCode']!='200'){

            $statusDescription=$_GET['statusDescription'];

            Session::flash('message', $statusDescription);

            return redirect('https://4unettinghub.com/admin/orderHeaders/create?message='.$statusDescription);

        }
        elseif($_GET['statusCode']=='200'){

            $statusDescription   =   $_GET['statusDescription'];
            $merchantRefNumber   =   $_GET['merchantRefNumber']; //new this attr is order header id
            $referenceNumber     = $_GET['referenceNumber'];
            $paymentMethod     = $_GET['paymentMethod'];
            $orderStatus     = $_GET['orderStatus'];
            $user_id     = $_GET['id'];

            $order_header=OrderHeader::select('id')->where('user_id',$user_id)->latest()->first();
            $order=DB::select('SELECT
       ol.price ,ol.quantity ,
       ol.product_id  "itemCode"
FROM order_lines ol
WHERE ol.order_id='.$order_header->id.'
	                      ');

            $total_order=$order_header->total_order;
            $pprice = $total_order < 225 ? 25.0 : 0.0;
            $order[] = (object) [
                'itemCode' => $order_header->id,
                'price' => $pprice,
                'quantity' => 1,
            ];

            $data = [
                "payment_number" => $referenceNumber,
                "payment_status" => $orderStatus,
                "payment_payment_method" => $paymentMethod,
                "payment_type" => PaymentNames::FAWRY_PAYMENT,
                "orderItems" => $order,
            ];
//            Log::info('fawryPayload',$data);
            $this->PaymentService->updateOrderPaymentNumber($order_header->id,$referenceNumber);
            $this->PaymentService->saveRequest($data);
            $orderHeaderId = $order_header->id;
            if ($orderHeaderId && $this->PaymentService->canChangeOrderStatus($orderHeaderId))
            {
                $orderHeader = $this->OrderService->getOrderHeader($orderHeaderId);
                ($data['payment_status'] == OrderStatus::PAID)? $this->PaymentService->payOrder($orderHeader,$data['payment_number']):$this->PaymentService->expiredOrder($orderHeader);
                return redirect('https://4unettinghub.com/admin/orderHeaders/create?message='.$statusDescription);
            }

            return redirect('https://4unettinghub.com/admin/orderHeaders/create?message='.$statusDescription);


//$statusDescription   =   $_GET['statusDescription'];
//$referenceNumber     = $_GET['referenceNumber'];
//
//    $id=$_GET['id'];
//   DB::table('order_headers')->where('created_for', $id)->update(['fawry_code' => $referenceNumber]);
//
//    DB::table('user_commissions')->where('commission_by', $id)
//       ->update([
//           'fawry_code' => $referenceNumber,
//        ]);
//
//   $user=DB::table('users')->where('id', $id)->first();
//
//$email=$user->email;
//$password=$user->password2;
//
//
//						require (__DIR__.'/../../../../mailSender3.php');
//							$mail->setFrom('info@nettinghub.com', 'Netting Hub');
//							$mail->CharSet = 'UTF-8';
//
//							$mail->AddCC('info@nettinghub.com');
//
//							$mail->addAddress($email, '');
//								     // Add a recipient
//							//$mail->addAddress('ellen@example.com');               // Name is optional
//							//$mail->addReplyTo('kyrellous.sherif@armaniousgroup.com', 'kyrellous shereif');
//							//$mail->addBCC('kyrellous.sherif@armaniousgroup.com');
//							//$mail->addCC('bcc@example.com');
//
//							//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//							//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//							$mail->isHTML(true);                                  // Set email format to HTML
//
//							$mail->Subject = 'congratulation mail';
//							$mail->Body= "
//<html>
//<head>
//<title>Weclome email</title>
//</head>
//
//
//
//<body>
//
//
//
//
//<img  src='http://nettinghub.com/logo2.png' alt='nettinghub'>
//
//<h3 style='color:rgb(0, 148, 167)'>Thank you for registration </h3>
//
//<p style='color:rgb(0, 148, 167)'>Your account password will be delivered within 24h. </p>
//
//
//
//<p style='color:rgb(0, 148, 167);' >If you have any questions, contact us at
//
//<a style='color:rgb(0, 148, 167);  text-decoration: underline;' href = 'mailto: info@nettinghub.com'>info@nettinghub.com</a>
//
//
//</p>
//
//
//
//</body>
//</html>
//";
//
//
//	if(!$mail->send()) {
//				echo 'Message could not be sent.';
//			echo 'Mailer Error: ' . $mail->ErrorInfo;
//			} else {
//				echo 'yes';
//			}
//
//
//date_default_timezone_set("Africa/Cairo");
//$date2 = date('YmdHis');
//
//
//   				$mob=$user->mob1;
//
//
//
//    $text='Thank you for registration \n \nYour account password will be delivered within 24h.';
//
//
//
//    $text=str_replace(' ', '%20', $text);
////echo $Date2;
//
//$url = "http://www.ezagel.com/portex_ws/service.asmx/Send_SMS?Msg_ID=$date2&Mobile_NO=%2B2$mob&Body=$text&Validty=&StartTime=&Sender=Netting%20Hub&User=Eva%20Cosmetics&Password=Eva@1234&Service=market";
//
//$contents = file_get_contents($url);
//$xml = simplexml_load_string($contents);
//
//
//
//   Auth::logout();
//   Session::flush();
//
//
//    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//
//if($actual_link=='https://www.atfawry.com/atfawry/plugin/payment/confirmation'){
//    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
//    echo"<script>
//    $(document).ready(function(){
//  $('payment-confirmation-btn').trigger('click');
//});
//    </script>";
//
//}
//
//
//   $order_Header =DB::table('order_headers')->where('created_for', $id)->first();
//    $order_lines = Order_line::select('order_lines.price','order_lines.quantity','products.id','products.sku')
//        ->join('products','products.oracle_short_code','order_lines.item_code')
//        ->where('order_lines.order_num',$order_Header->order_num)->get();
//    $arrayOrderLines=[];
//    foreach ($order_lines as $line)
//    {
//        $arrayOrderLines[] = [
//            "id" => $line['id'],
//            "quantity" => $line['quantity'],
//            "price" => $line['price'],
//            "sku" => $line['sku'],
//        ];
//    }
//    return redirect()->route('thanksPay', ['order_header' => $order_Header, 'order_lines' => $arrayOrderLines,'payment_method'=> $_GET['paymentMethod']]);
//
//

        }


    }

    public function complete(){

        return view('complete');

    }


    public function completestore(Request $request){


        $mobile=$request->mobile;
        $mobile1 = trim(preg_replace('/[^\p{L}\p{N}\s]/u', '', $mobile));
        $email=$request->email;
        $usercount=User::where('email',$email)->where('mob1',$mobile1)->count();
        if($usercount>0){
            $user=User::where('email',$email)->where('mob1',$mobile1)->first();
            $stage=$user->stage;
            if($stage==1){
                if (Auth::login($user)) {
                    $products = Product::where('stock_status','in stock')->get();
                    $product = Category::distinct()->get(['name_en','id']);
                }
                return redirect('shop');


            }elseif($stage==2){

                Auth::logout();
                Session::flush();
                $email=$user->email;
                $password=$user->password2;
                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $id=$user->id;
                    $cart=DB::select('SELECT  l.item_code oracle_short_code, i.id id , p.image image , p.sku sku , p.price price,l.quantity quantity   FROM order_lines l , items i ,products p WHERE l.item_code = i.ITEM_CODE and l.created_for ='.$id.' and p.oracle_short_code = l.item_code');
                    foreach($cart as $carts){
                        Cart::add(array(
                            'id' => $carts->id,
                            'sku' => $carts->sku,
                            'oracle_short_code'=>$carts->oracle_short_code,
                            'price' => $carts->price,
                            'quantity' => $carts->quantity,
                            'attributes' => array(
                                'image' => $carts->image,
                                'sku' => $carts->sku
                            )
                        ));
                    }
                    ($cartCollection = Cart::getContent());

                    return redirect('cart');


                }
            }elseif($stage==3){

                return redirect()->route('complete')->with('message', 'This Email is completely register
');

            }

        }else{



            return redirect('complete')
                ->with('message',"Invaled mail or phone sorry check again or to register as new member go to join our family")
                ->with('status', 'danger');



        }
    }

}
