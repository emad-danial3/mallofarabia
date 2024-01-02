<?php

namespace App\Http\Services;

use App\Http\Repositories\CartRepository;
use App\Http\Repositories\OrderLinesRepository;

class OrderLinesService extends BaseServiceController
{
    private $OrderLinesRepository;
    private $CartRepository;

    public function __construct(OrderLinesRepository $OrderLinesRepository, CartRepository $CartRepository)
    {
        $this->OrderLinesRepository = $OrderLinesRepository;
        $this->CartRepository       = $CartRepository;
    }

    public function createOrderLines($order_id, $user_id)
    {
        $OrderTypesArray = [];
        $getMaxNumber    = $this->OrderLinesRepository->getMaxNumber();
        $getCartLines    = $this->CartRepository->getMyCart($user_id);

        foreach ($getCartLines as $key => $orderLine) {

                 if (!array_key_exists('number', $OrderTypesArray)) {
                    $getMaxNumber                        += 1;
                    $OrderTypesArray['number'] = $this->GenerateOracleNumber($getMaxNumber);
                }
                $this->OrderLinesRepository->createLines($orderLine, $order_id, $OrderTypesArray['number'], $getMaxNumber);

        }
    }

    private function GenerateOracleNumber($max): string
    {
        // start oracle Number
        $max_num         = $max;
        $user_oracle_num = 10241;
        $date            = date("dmy");
        if (strlen((string)$max_num) == 1) {
            $max_num = '0000' . $max_num;
        }
        if (strlen((string)$max_num) == 2) {
            $max_num = '000' . $max_num;
        }
        elseif (strlen((string)$max_num) == 3) {
            $max_num = '00' . $max_num;
        }
        elseif (strlen((string)$max_num) == 4) {
            $max_num = '0' . $max_num;
        }

        return $user_oracle_num . $date . '-' . $max_num;

    }

    public function deleteCartAndCartHeader($user_id)
    {
        $this->CartRepository->deleteUserProducts($user_id);
        $this->CartRepository->deleteCartHeader($user_id);
    }
}
