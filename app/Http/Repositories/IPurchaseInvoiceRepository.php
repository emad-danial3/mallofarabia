<?php

namespace App\Http\Repositories;

use App\Constants\OrderStatus;
use App\Models\PurchaseInvoices;
use App\Models\PurchaseInvoiceLines;
use Illuminate\Support\Facades\DB;

class IPurchaseInvoiceRepository extends BaseRepository implements PurchaseInvoiceRepository
{
    public function __construct(PurchaseInvoices $model)
    {
        parent::__construct($model);
    }

    public function isFirstOrder($created_for_user_id)
    {
        return PurchaseInvoices::where([
            'created_for_user_id' => $created_for_user_id,
            'payment_status'        => OrderStatus::PAID
        ])->count();
    }

    public function createOrder($orderHeaderData)
    {
         PurchaseInvoices::create($orderHeaderData);
         return DB::getPdo()->lastInsertId();
    }

    public function getOrder($order_id)
    {
        return DB::table('order_lines')
            ->join('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->join('users', 'order_headers.created_for_user_id', '=', 'users.id')
            ->join('products', 'order_lines.product_id', '=', 'products.id')
            ->join('companies','products.flag','companies.id')
            ->selectRaw('select order_line.price * 14/100 as real_price')
            ->where('order_headers.id',$order_id)
            ->whereIn('products.flag',[5,8,9])
            ->where('order_lines.price','!=',0)
            ->select('users.account_id  as serial', 'order_lines.oracle_num  as orecal_number',
                'products.oracle_short_code as item_code','order_lines.quantity','order_lines.price',
                DB::raw('(order_lines.price * products.tax/100) AS tax'),
                DB::raw('(order_lines.price + (order_lines.price * 14/ 100 )) * order_lines.quantity AS s')
                ,'order_headers.payment_code',
                  DB::raw("IF(order_headers.wallet_status ='full_wallet',1,0) AS  wallet_status"),
                'order_headers.gift_category_id as has_free_product',
                'companies.name_en as grandbrand')
            ->orderBy('order_lines.oracle_num')
            ->get();
    }

    public function updateOrder($conditions, $data)
    {
       return PurchaseInvoices::where($conditions)->update($data);
    }

    public function getMyOrder($user_id)
    {
        if (request()->has('start_date') && request()->has('end_date'))
        return PurchaseInvoices::select('order_headers.id','users.full_name','account_types.name_en as user_type','users.account_id','order_headers.created_at','order_headers.total_order','order_headers.payment_status')
                            ->where('order_headers.user_id',$user_id)
                            ->whereBetween(DB::raw('DATE(order_headers.updated_at)'),[request()->input('start_date'),request()->input('end_date')])
                            ->join('users','users.id','order_headers.created_for_user_id')
                            ->join('account_types','account_types.id','users.account_type')
                            ->orderBy('order_headers.payment_paid_date')
                            ->get();
        else
            return PurchaseInvoices::select('order_headers.id','users.full_name','account_types.name_en as user_type','users.account_id','order_headers.created_at','order_headers.total_order','order_headers.payment_status')
                ->where('order_headers.user_id',$user_id)
                ->join('users','users.id','order_headers.created_for_user_id')
                ->join('account_types','account_types.id','users.account_type')
                ->orderBy('order_headers.payment_paid_date')
                ->get();
    }

    public function getMyOrderDetails($order_id): array
    {
        $orderHeader = PurchaseInvoices::select('order_headers.total_order','order_headers.order_status',
            'order_headers.payment_code','order_headers.shipping_amount','order_headers.address','order_headers.city',
            'order_headers.city','order_headers.area','order_headers.building_number',
            'order_headers.landmark','order_headers.floor_number','order_headers.apartment_number',
            'order_headers.payment_status',
            'order_headers.order_status','order_headers.wallet_status','order_headers.created_at')
            ->where('order_headers.id',$order_id)
            ->first();
        $products = PurchaseInvoices::select(
            'products.id','products.name_ar','products.name_en','order_lines.price','order_lines.quantity',
            'products.image')
            ->join('order_lines','order_lines.order_id','order_headers.id')
            ->join('products','products.id','order_lines.product_id')
            ->where('order_headers.id',$order_id)
            ->get();

        return [
          "order_header" => $orderHeader,
          "order_lines" => $products
        ];
    }

    public function getAllData($inputData)
    {
        $country = PurchaseInvoices::orderBy('created_at','desc');
        if (isset($inputData['name']))
        {
            $country->where('id',$inputData['name']);
        }
        elseif(isset($inputData['user_name'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('full_name','like','%'.$inputData['user_name'].'%');
            });
        }
        elseif(isset($inputData['user_serial_number'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('account_id',$inputData['user_serial_number']);
            });
        }  elseif(isset($inputData['phone'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('phone',$inputData['phone']);
            });
        }
        if (isset($inputData['type']))
        {
            $country->where('payment_status',$inputData['type'])->orderBy('updated_at','desc');
        }
        return  $country->paginate($this->defaultLimit);
    }

    public function updateData($conditions, $updatedData)
    {
        return PurchaseInvoices::where($conditions)->update($updatedData);
    }
}
