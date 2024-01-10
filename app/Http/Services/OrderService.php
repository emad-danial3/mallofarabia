<?php


namespace App\Http\Services;

use App\Constants\OrderStatus;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\OrderRepository;

class OrderService extends BaseServiceController
{
    private $OrderRepository;
    private $OrderLinesService;
    private $CartRepository;

    public function __construct(CartRepository $CartRepository, OrderRepository $OrderRepository, OrderLinesService $OrderLinesService)
    {
        $this->OrderRepository = $OrderRepository;
        $this->OrderLinesService = $OrderLinesService;
        $this->CartRepository = $CartRepository;
    }

    public function createOrderHeader($orderData, $address)
    {
        $cartOrderHeader = $this->CartRepository->getMyCartHeader($orderData['user_id'], $orderData['created_for_user_id']);
        if (isset($cartOrderHeader)) {
            $orderHeaderData = [
                'payment_code' => (isset($orderData['payment_code'])) ? $orderData['payment_code'] : NULL,
                'total_order' => $cartOrderHeader['total_products_after_discount'],
                'user_id' => $orderData['user_id'],//created by
                'created_for_user_id' => $orderData['created_for_user_id'],//created for
                'order_type' => $orderData['order_type'],
                'shipping_amount' => $cartOrderHeader['shipping_amount'],
                'address' => $address['address'],
                'city' => $address['city'],
                'area' => $address['area'],
                'building_number' => $address['building_number'],
                'landmark' => $address['landmark'],
                'floor_number' => $address['floor_number'],
                'apartment_number' => $address['apartment_number'],
                'gift_category_id' => $cartOrderHeader['gift_category_id']
            ];
            $orderHeaderData['id'] = $this->OrderRepository->createOrder($orderHeaderData);

            return $orderHeaderData;
        }

        return 0;
    }

    public function getOrderHeader($order_id)
    {
        return $this->OrderRepository->find($order_id, ['id', 'total_order', 'user_id']);
    }

    public function updatePaymentCode($order_id, $payment_code)
    {
        return $this->OrderRepository->updateOrder(['id' => $order_id], ['payment_code' => $payment_code]);
    }

    public function getMyOrder($user_id)
    {

        return $this->OrderRepository->getMyOrder($user_id);
    }
  public function cancelOrder($user_id)
    {
        return $this->OrderRepository->cancelOrder($user_id);
    }

    public function getMyOrderDetails($order_id)
    {
        return $this->OrderRepository->getMyOrderDetails($order_id);
    }

    public function getAll($inputData)
    {
        return $this->OrderRepository->getAllData($inputData);
    }
    public function getOrders($inputData)
    {
        return $this->OrderRepository->getRepoOrders($inputData);

    }
    public function updateRow($updatedData, $id)
    {
        return $this->OrderRepository->updateData(['id' => $id], $updatedData);
    }

    public function getPendingOrders()
    {
        return $this->OrderRepository->getAll(['id', 'payment_code'], ['payment_status' => OrderStatus::PENDING]);
    }


    public function createOrderHeaderForWallet($orderData, $address)
    {
        $cartOrderHeader = $this->CartRepository->getMyCartHeader($orderData['user_id'], $orderData['created_for_user_id']);
        if (isset($cartOrderHeader)) {
            $orderHeaderData = [
                'payment_code' => (isset($orderData['payment_code'])) ? $orderData['payment_code'] : NULL,
                'total_order' => $cartOrderHeader['total_products_after_discount'],
                'user_id' => $orderData['user_id'],
                'created_for_user_id' => $orderData['created_for_user_id'],
                'order_type' => $orderData['order_type'],
                'shipping_amount' => $cartOrderHeader['shipping_amount'],
                'address' => $address['address'],
                'city' => $address['city'],
                'area' => $address['area'],
                'building_number' => $address['building_number'],
                'landmark' => $address['landmark'],
                'floor_number' => $address['floor_number'],
                'apartment_number' => $address['apartment_number'],
                'gift_category_id' => $cartOrderHeader['gift_category_id'],

                'wallet_status' => $orderData['wallet_status'],
                'payment_status'=>$orderData['payment_status']
            ];
            $orderHeaderData['id'] = $this->OrderRepository->createOrder($orderHeaderData);
            return $orderHeaderData;
        }
        return 0;
    }

}

