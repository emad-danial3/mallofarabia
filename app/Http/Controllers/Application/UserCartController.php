<?php

namespace App\Http\Controllers\Application;

use App\Http\Services\ProductService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Models\OrderHeader;
use App\Libraries\ApiValidator;
use App\ValidationClasses\ProductsValidation;
use App\ValidationClasses\UserValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Repositories\CartRepository;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\App;
use App\Http\Services\PaymentService;
use App\Http\Services\OrderLinesService;

class UserCartController extends HomeController
{
    protected $API_VALIDATOR;
    protected $API_RESPONSE;
    protected $CartService;
    protected $ProductsValidation;
    protected $ProductService;
    protected $UserService;
    protected $UserValidation;
    protected $CartRepository;
    protected $OrderLinesService;
    protected $PaymentService;

    public function __construct(UserService $UserService, PaymentService $PaymentService, OrderLinesService $OrderLinesService, UserValidation $UserValidation, CartRepository $CartRepository, CartService $CartService, ProductService $ProductService, ApiValidator $apiValidator, ApiResponse $API_RESPONSE, ProductsValidation $ProductsValidation)
    {
        $this->CartRepository     = $CartRepository;
        $this->API_VALIDATOR      = $apiValidator;
        $this->API_RESPONSE       = $API_RESPONSE;
        $this->CartService        = $CartService;
        $this->ProductsValidation = $ProductsValidation;
        $this->ProductService     = $ProductService;
        $this->UserService        = $UserService;
        $this->UserValidation     = $UserValidation;
        $this->OrderLinesService  = $OrderLinesService;
        $this->PaymentService     = $PaymentService;
    }

    public function addProductToCart(Request $request)
    {
        $add          = null;
        $productexist = $this->CartRepository->getCartProduct($request->user_id, $request->product_id);
        if (isset($productexist) && !empty($productexist) && !is_null($productexist)) {
            // update it
            $product  = $this->CartRepository->getCartProduct($request->user_id, $request->product_id);
            $nproduct = [
                'quantity'             => $request->quantity > 0 ? $request->quantity : 1,
                'price'                => $request->price,
                'price_after_discount' => $request->price_after_discount
            ];
            $this->CartRepository->updateMyCart($product->id, $nproduct);
        }
        else {
            $product = json_encode([
                'user_id'              => $request->user_id,
                'id'                   => $request->product_id,
                'quantity'             => $request->quantity,
                'price'                => $request->price,
                'flag'                 => $request->flag,
                'price_after_discount' => $request->price_after_discount
            ]);
            $add     = $this->CartRepository->safeProduct(json_decode($product), $request->user_id, $request->user_id);
        }
        $cart = $this->updateMyCartHeader($request->user_id);
        return $this->API_RESPONSE->data(["cart" => $cart], 'product added successfully ', 200);
    }

    public function deleteProductFromCart(Request $request)
    {
        $delete = $this->CartRepository->deleteOneCartWithUserProduct($request->user_id, $request->product_id);
        $cart   = $this->updateMyCartHeader($request->user_id);
        return $this->API_RESPONSE->data(['product' => [], "cart" => $cart], 'product deleted successfully ', 200);
    }

    public function getMyCart(Request $request)
    {
        $products = $this->CartRepository->getMyCart($request->user_id, $request->user_id);
        $cart     = $this->updateMyCartHeader($request->user_id);
        return $this->API_RESPONSE->data(['products' => $products, "cart" => $cart], 'myCart', 200);
    }

    public function saveOrderApp(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->orderRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->orderRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $inputs      = $request->all();
        $currentuser = $this->UserService->getUser($request->user_id);
        if ($currentuser->created_at < '2023-04-19') {
            $now  = Carbon::now()->toDateTimeString();
            $data = ['created_at' => $now];
            $this->UserService->updateUserRow($data, $currentuser->id);
        }
        $hasDiscount = $currentuser->stage == 2 ? 1 : 0;

        $productsAndTotal = $this->CartService->calculateProducts($inputs['items'], $hasDiscount);
        if (!empty($productsAndTotal) && isset($productsAndTotal['products']) && count($productsAndTotal['products']) > 0) {
            $productsAndTotal['shipping'] = ((float)$productsAndTotal['totalProductsAfterDiscount']) < 250 ? 50 : 0;
            $this->CartService->saveProductsToCart(array_merge($productsAndTotal['products'],$productsAndTotal['giftProducts']) , $request->user_id, $request->user_id);
            $this->CartService->saveCartHeader($request->user_id, $request->user_id, $productsAndTotal['totalProducts'], $productsAndTotal['totalProductsAfterDiscount'], $productsAndTotal['shipping'], $productsAndTotal['discount_amount']);

            if(isset($productsAndTotal['userRedeemGift']) && $productsAndTotal['userRedeemGift'] == true){
                array_push($productsAndTotal['products'],$productsAndTotal['returngift']);
            }

            $data              = [
                "user_id"                    => $currentuser->id,
                "address_id "                => intval($inputs['address_id']),
                "shipping_amount"            => $productsAndTotal['shipping'],
                'payment_code'               => NULL,
                'wallet_status'              => $inputs['wallet_status'],
                'total_order'                => (float)$productsAndTotal['totalProductsAfterDiscount'] + $productsAndTotal['shipping'],

                'totalProducts'              => (float)$productsAndTotal['totalProducts'],
                'discount_amount'            => $productsAndTotal['discount_amount'],
                'platform'                   => 'mobile',
                'gift_id'                    => isset($productsAndTotal['userRedeemGift']) && $productsAndTotal['userRedeemGift'] == true ? $productsAndTotal['userIdGift'] : 0
            ];
            $order             = OrderHeader::create($data);
            $order->address_id = intval($inputs['address_id']);
            $order->save();
            if (!empty($order)) {
                $productsAndTotal['order_id']       = $order->id;
                $productsAndTotal['wallet_status']  = $order->wallet_status;
                $productsAndTotal['payment_status'] = $order->payment_status;
                $this->OrderLinesService->createOrderLines($order['id'], $data['user_id'], $data['user_id']);
//                $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['user_id']);
                if ($inputs['wallet_status'] == 'cash') {
                     $this->OrderLinesService->deleteCartAndCartHeader($data['user_id'], $data['user_id']);
//                    $this->PaymentService->sendOrderToOracle($order->id);
//                    if (isset($order->id) && $order->id > 0) {
//                        $this->ProductService->updateOrderProductQuntity($order->id);
//                    }
                }
            }
            return $this->API_RESPONSE->data(['data' => $productsAndTotal], 'Order Add Success', 200);
        }
        return $this->API_RESPONSE->data(['data' => null], 'no products', 200);
    }

    public function getOrderCheckout(Request $request)
    {

        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->orderCheckRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->orderCheckRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $inputs      = $request->all();
        $currentuser = $this->UserService->getUser($request->user_id);
        $hasDiscount = $currentuser->stage == 2 ? 1 : 0;

//        $checkItemsAvalability = $this->CartService->checkItemsAvalability($inputs['items']);
//
//        if ($checkItemsAvalability && count($checkItemsAvalability) > 0) {
//            return $this->API_RESPONSE->errors(['products' => 'products Quantity More than Quantity In stock  Or more than 6 piece'], 400);
//        }
        $productsAndTotal = $this->CartService->calculateProducts($inputs['items'], $hasDiscount);
        if (!empty($productsAndTotal)) {
            $productsAndTotal['shipping']                  = ((float)$productsAndTotal['totalProductsAfterDiscount']) < 250 ? 50 : 0;
            $productsAndTotal['total_order_final']         = ((float)$productsAndTotal['totalProductsAfterDiscount']) + $productsAndTotal['shipping'];
            $productsAndTotal['value_will_has_commission'] = $hasDiscount == 1? (float)$productsAndTotal['value_will_has_commission']:0;
        }
        $gift = null;

        if ($hasDiscount == 1 ) {
            $userHasReceivedGift          = $this->UserService->userHasReceivedGift([$currentuser->id]);
            $myOldPaidOrderThisMonthTotal = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'month');

            if (((float)$productsAndTotal['totalProductsAfterDiscount'] + $myOldPaidOrderThisMonthTotal) >= 250 && $userHasReceivedGift == false) {

                $gift = $this->checkUserDeserveGift($currentuser->id, $currentuser->created_at);

                if (!empty($gift)) {
                    $gift->flag                 = 5;
                    $gift->excluder_flag        = "N";
                    $gift->old_price            = $gift->total_old_price;
                    $gift->old_discount         = round((($gift->total_old_price - $gift->total_price) * 100) / $gift->total_old_price);
                    $gift->discount_rate        = round((($gift->total_old_price - $gift->total_price) * 100) / $gift->total_old_price);
                    $gift->full_name            = $gift->name_ar;
                    $gift->description_en       = $gift->name_en;
                    $gift->description_ar       = $gift->name_ar;
                    $gift->oracle_short_code    = "1100110011";
                    $gift->price_after_discount = $gift->total_price;
                    $gift->price                = $gift->total_price;
                    $gift->quantity             = 1;
                    $gift->stock_status         = "in stock";
                    $gift->userRedeemGift       = true;
                }
            }
        }
        $productsAndTotal['gift'] = $gift;
        $conditions               = ['user_addresses.user_id', '=', $currentuser->id];
        $address                  = $this->UserService->getMyMainAddresse($conditions);
        if (!empty($address)) {
            $productsAndTotal['address'] = $this->UserService->getMyMainAddresse($conditions);
        }
        $total = $this->CartRepository->getTotalProducts($currentuser->id);
        if ($total <= 0) {
            $productsAndTotal['products'] = [];
        }
        if (!empty($productsAndTotal) && isset($productsAndTotal['products']) && count($productsAndTotal['products']) > 0) {
            foreach ($productsAndTotal['products'] as $rProduct) {
                $rProduct->old_price    = $rProduct->price;
                $rProduct->price        = $rProduct->price_after_discount;
                $rProduct->old_discount = $rProduct->discount_rate;
            }
             if(isset($productsAndTotal['userRedeemGift']) && $productsAndTotal['userRedeemGift'] == true){
                array_push($productsAndTotal['products'],$productsAndTotal['returngift']);
            }
        }
        if(isset($productsAndTotal['userRedeemGift'] ) && $productsAndTotal['userRedeemGift'] == true){

            $productsAndTotal['gift']=null;
              unset($productsAndTotal['giftProducts']);
              unset($productsAndTotal['returngift']);


        }

        return $this->API_RESPONSE->data($productsAndTotal, 'check out', 200);
    }


    public function updateMyCartHeader($user_id)
    {
        $total              = $this->CartRepository->getTotalProducts($user_id);
        $totalAfterDiscount = $this->CartRepository->getTotalProductsAfter($user_id);
        $shipping_amount    = $total >= 250 ? 0 : 50;
        $discount_amount    = $total - $totalAfterDiscount;
        $this->CartRepository->deleteCartHeader($user_id, $user_id);
        $cart    = $this->CartRepository->safeCartHeader($user_id, $user_id, $total, $totalAfterDiscount, $shipping_amount, $discount_amount);
        $newCart = [
            "user_id"              => $cart->user_id,
            "total_products_price" => $cart->total_products_price,
            "shipping_amount"      => $cart->shipping_amount,
            "total"                => ($cart->total_products_price + $cart->shipping_amount),
            "vip_total"            => ($cart->total_products_after_discount),
        ];
        return $newCart;
    }

    public function checkUserDeserveGift($user_id, $created_at)
    {
        return $this->UserService->checkUserDeserveGift($user_id, $created_at);
    }


}
