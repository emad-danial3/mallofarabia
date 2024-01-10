<?php

namespace App\Http\Repositories;

use App\Constants\OrderStatus;
use App\Models\OrderHeader;
use App\Models\User;
use App\Models\WelcomeProgramProduct;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\True_;


class IOrderRepository extends BaseRepository implements OrderRepository
{
    public function __construct(OrderHeader $model)
    {
        parent::__construct($model);
    }

    public function isFirstOrder($created_for_user_id)
    {
        return OrderHeader::where([
            'created_for_user_id' => $created_for_user_id,
            'payment_status'      => OrderStatus::PAID
        ])->count();
    }

    public function createOrder($orderHeaderData)
    {
        OrderHeader::create($orderHeaderData);
        return DB::getPdo()->lastInsertId();
    }

    public function getOrder($order_id)
    {
        return DB::table('order_lines')
            ->join('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->join('users', 'order_headers.user_id', '=', 'users.id')
            ->join('products', 'order_lines.product_id', '=', 'products.id')
            ->join('companies', 'products.flag', 'companies.id')
            ->selectRaw('select order_line.price * 14/100 as real_price')
            ->where('order_headers.id', $order_id)
            ->whereIn('products.flag', [5, 8, 9, 23, 7])
            ->where('order_lines.price', '!=', 0)
            ->select('users.account_id  as serial', 'order_lines.oracle_num  as orecal_number',
                'products.oracle_short_code as item_code', 'products.excluder_flag', 'products.flag', 'order_lines.quantity', 'order_lines.price',
                DB::raw('(order_lines.price * products.tax/100) AS tax'),
                DB::raw('(order_lines.price + (order_lines.price * 14/ 100 )) * order_lines.quantity AS s')
                , 'order_headers.payment_code',
                'companies.name_en as grandbrand')
            ->orderBy('order_lines.oracle_num')
            ->get();
    }


    public function updateOrder($conditions, $data)
    {
        return OrderHeader::where($conditions)->update($data);
    }

    public function userIsActiveInCurrentMonth($user_id)
    {

        $startMonth       = Carbon::now()->startOfMonth()->toDateTimeString();
        $endMonth         = Carbon::now()->endOfMonth()->toDateTimeString();
        $roralOrders      = OrderHeader::where(['user_id' => $user_id, 'payment_status' => 'PAID'])->whereBetween('created_at', [$startMonth, $endMonth])->sum('total_order');
        $isUserNewRecruit = User::where('id', $user_id)->whereBetween('created_at', [$startMonth, $endMonth])->count();
        $data             = [
            "active" => $roralOrders >= 250 ? true : false,
            "total"  => (float)$roralOrders,
            "new"    => $isUserNewRecruit,
        ];
        return $data;
    }

    public function checkUserDeserveGift($user_id, $created_at)
    {
        $createdate        = Carbon::parse($created_at)->toDateString();
        $before3month      = Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString();
        $before3monthend   = Carbon::now()->subMonths(2)->endOfMonth()->toDateTimeString();
        $before2month      = Carbon::now()->subMonths(1)->startOfMonth()->toDateTimeString();
        $before2monthend   = Carbon::now()->subMonths(1)->endOfMonth()->toDateTimeString();
        $startCurrentMonth = Carbon::now()->startOfMonth()->toDateTimeString();

        if ($createdate >= $before3month) {
            if ($createdate >= $startCurrentMonth) {
                // first gift
                return WelcomeProgramProduct::where('month', '1')->where('status', '1')->first();
            }
            elseif ($createdate >= $before2month && $createdate < $before2monthend) {
                // second gift
                $roralOrders = OrderHeader::where(['user_id' => $user_id, 'payment_status' => 'PAID'])->whereBetween('created_at', [$before2month, $before2monthend])->sum('total_order');
                return (float)$roralOrders >= 250 ? WelcomeProgramProduct::where('month', '2')->where('status', '1')->first() : null;
            }
            else {
                // third gift
                $roralOrders1 = OrderHeader::where(['user_id' => $user_id, 'payment_status' => 'PAID'])->whereBetween('created_at', [$before2month, $before2monthend])->sum('total_order');
                $roralOrders2 = OrderHeader::where(['user_id' => $user_id, 'payment_status' => 'PAID'])->whereBetween('created_at', [$before3month, $before3monthend])->sum('total_order');
                return (float)$roralOrders1 >= 250 && (float)$roralOrders2 >= 250 ? WelcomeProgramProduct::where('month', '3')->where('status', '1')->first() : null;
            }
        }
        return null;
    }

    public function getUsersActiveSalesTeam($team)
    {
        $startMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endMonth   = Carbon::now()->endOfMonth()->toDateTimeString();
        return DB::table('order_headers')
            ->join('users', 'order_headers.user_id', '=', 'users.id')
            ->where('order_headers.payment_status', 'PAID')
            ->whereBetween('order_headers.created_at', [$startMonth, $endMonth])
            ->whereIn('order_headers.user_id', $team)
            ->select('users.id', 'users.full_name', 'users.email', 'users.phone', DB::raw('SUM(order_headers.total_order) as total_sales'))
            ->groupBy('users.id')
            ->havingRaw('SUM(order_headers.total_order) > ?', [250])
            ->get();
    }

    public function getUsersNotActiveSalesTeam($team)
    {
        $startMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endMonth   = Carbon::now()->endOfMonth()->toDateTimeString();
        return DB::table('users')
            ->leftJoin('order_headers', function (JoinClause $join) use ($startMonth, $endMonth) {
                $join->on('users.id', '=', 'order_headers.user_id')->where('order_headers.payment_status', 'PAID')->whereBetween('order_headers.created_at', [$startMonth, $endMonth]);
            })
            ->whereIn('users.id', $team)
            ->select('users.id', 'users.full_name', 'users.email', 'users.phone', DB::raw('SUM(order_headers.total_order) as total_sales'))
            ->groupBy('users.id')
            ->get();
    }


    public function getMyTeamTotalSales($team, $period = 'month')
    {
        if ($period == 'quarter') {
            $start = Carbon::now()->firstOfQuarter()->toDateTimeString();
            $end   = Carbon::now()->lastOfQuarter()->toDateTimeString();
        }
        elseif ($period == 'year') {
            $start = Carbon::now()->copy()->startOfYear()->toDateTimeString();
            $end   = Carbon::now()->copy()->endOfYear()->toDateTimeString();
        }
        else {
            $start = Carbon::now()->startOfMonth()->toDateTimeString();
            $end   = Carbon::now()->endOfMonth()->toDateTimeString();
        }

        $totalOrders = OrderHeader::where('payment_status', 'PAID')->whereIn('user_id', $team)->whereBetween('created_at', [$start, $end])->sum('total_order');
        return (float)$totalOrders;
    }

    public function userHasReceivedGift($id)
    {
        $start = Carbon::now()->startOfMonth()->toDateTimeString();
        $end   = Carbon::now()->endOfMonth()->toDateTimeString();
        $order = OrderHeader::where('gift_id', '>', 0)->where('user_id', $id)->whereBetween('created_at', [$start, $end])->first();
        return $order ? true : false;
    }

    public function getMyOrder($user_id)
    {

        if (request()->has('start_date') && request()->has('end_date'))
            return OrderHeader::select('order_headers.id', 'order_headers.discount_amount', 'order_headers.created_at', 'order_headers.shipping_amount', 'users.full_name', 'users.account_id', 'order_headers.created_at', 'order_headers.total_order', 'order_headers.total_order', 'order_headers.payment_status', 'order_headers.order_status', DB::raw("(IF(order_headers.wallet_status ='cash' && order_headers.payment_status !='PAID' && order_headers.order_status !='Cancelled' ,true,false)) as  can_cancel"))
                ->where('order_headers.user_id', $user_id)
                ->whereBetween(DB::raw('DATE(order_headers.updated_at)'), [request()->input('start_date'), request()->input('end_date')])
                ->join('users', 'users.id', 'order_headers.user_id')
                ->orderBy('order_headers.id', 'DESC')
                ->get();
        else
            return OrderHeader::select('order_headers.id', 'order_headers.created_at', 'order_headers.discount_amount', 'order_headers.shipping_amount', 'users.full_name', 'users.account_id', 'order_headers.created_at', 'order_headers.total_order', 'order_headers.total_order', 'order_headers.payment_status', 'order_headers.order_status', DB::raw("(IF(order_headers.wallet_status ='cash' && order_headers.payment_status !='PAID'&& order_headers.order_status !='Cancelled' ,true,false)) as  can_cancel"), DB::raw("(SELECT COUNT(DISTINCT order_lines.id) FROM order_lines WHERE order_lines.order_id=order_headers.id) AS  products_amount"))
                ->where('order_headers.user_id', $user_id)
                ->join('users', 'users.id', 'order_headers.user_id')
                ->orderBy('order_headers.id', 'DESC')
                ->get();
    }

    public function getMyOrderDetails($order_id): array
    {
        $orderHeader = OrderHeader::select('order_headers.id', 'order_headers.total_order', 'order_headers.total_order', 'order_headers.order_status', 'order_headers.gift_id',
            'order_headers.payment_code', 'order_headers.shipping_amount', 'order_headers.discount_amount', DB::raw("(IF(order_headers.wallet_status ='cash' && order_headers.payment_status !='PAID' && order_headers.order_status !='Cancelled' ,true,false)) as  can_cancel"),
            'order_headers.address_id',
            'order_headers.payment_status',
            DB::raw('(order_headers.total_order + order_headers.discount_amount - order_headers.shipping_amount ) as subtotal '),
            'order_headers.order_status', 'order_headers.wallet_status', 'order_headers.created_at')
            ->where('order_headers.id', $order_id)
            ->first();
        $products    = OrderHeader::select(
            'products.id', 'products.name_ar', 'products.name_en', 'products.full_name', 'products.oracle_short_code', 'order_lines.price', 'order_lines.price_before_discount', 'order_lines.discount_rate', 'order_lines.quantity',
            'products.image')
            ->join('order_lines', 'order_lines.order_id', 'order_headers.id')
            ->join('products', 'products.id', 'order_lines.product_id')
            ->where('order_headers.id', $order_id)
            ->get();

        $orderStatusOrder = [
            ['id' => 1, 'index' => 'pending', 'name' => 'Pending', 'isComplete' => false],
            ['id' => 2, 'index' => 'shipped', 'name' => 'Shipped', 'isComplete' => false],
            ['id' => 3, 'index' => 'Out For Delivery', 'name' => 'Out For Delivery', 'isComplete' => false],
            ['id' => 4, 'index' => 'Delivered', 'name' => 'Delivered', 'isComplete' => false],
            ['id' => 5, 'index' => 'Cancelled', 'name' => 'Cancelled', 'isComplete' => false],
        ];

        for ($i = 0; $i < count($orderStatusOrder); $i++) {
            if ($orderHeader['order_status'] == $orderStatusOrder[$i]['index']) {
                $orderStatusOrder[$i]['isComplete']  = true;
                $orderHeader['current_status_index'] = $i + 1;
            }
        }
        $orderHeader['max_status_index'] = count($orderStatusOrder) - 1;
        return [
            "order_header" => $orderHeader,
            "order_lines"  => $products,
            "order_status" => $orderStatusOrder
        ];
    }

    public function cancelOrder($order_id)
    {
        $orderHeader = OrderHeader::where('id', $order_id)->first();
        if ($orderHeader) {
            $orderHeader->order_status = 'Cancelled';
            $orderHeader->save();
        }
        return $orderHeader;
    }

    public function getRepoOrders($inputData)
    {
        $orders = OrderHeader::orderBy('order_headers.created_at', 'desc')
                ->paginate(config('constants.page_items_count'));
        return $orders ;
    }
    public function getAllData($inputData)
    {

        $country = OrderHeader::orderBy('order_headers.created_at', 'desc');
        if (isset($inputData['name'])) {
            $country->where('id', $inputData['name']);
        }
        elseif (isset($inputData['user_serial_number'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('account_id', $inputData['user_serial_number']);
            });
        }
        elseif (isset($inputData['user_name'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('full_name', 'like', '%' . $inputData['user_name'] . '%');
            });
        }
        elseif (isset($inputData['phone'])) {
            $country->whereHas('user', function ($query) use ($inputData) {
                return $query->where('phone', $inputData['phone']);
            });
        }
        if (isset($inputData['type'])) {
            $country->where('payment_status', $inputData['type'])->orderBy('updated_at', 'desc');
        }
        if (isset($inputData['from_date']) && isset($inputData['to_date'])) {
            $country->whereBetween('created_at', [$inputData['from_date'], $inputData['to_date']]);
        }
        if (isset($inputData['send_t_o'])) {
            $country->where(function ($query) {
                $query->where('payment_status', 'PAID')->orWhere('wallet_status', 'cash');
            })->where('user_id', '!=', '1')->where('send_t_o', $inputData['send_t_o'])->where('created_at', '>', \Illuminate\Support\Carbon::now()->subDays(2))->orderBy('updated_at', 'desc');
        }
        if (isset($inputData['send_t_o_not_return']) && $inputData['send_t_o_not_return'] == '1') {
            $country->leftJoin('order_lines', 'order_lines.order_id', '=', 'order_headers.id')
                ->leftJoin('products', 'products.id', '=', 'order_lines.product_id')
                ->leftJoin('oracle_invoices', 'oracle_invoices.web_order_number', '=', 'order_lines.oracle_num')
                ->whereIn('products.flag', [5, 7, 9, 23])
                ->where('order_headers.send_t_o', '1')->where('order_headers.user_id', '!=', '1')->whereNotNull('order_headers.id')->whereNull('oracle_invoices.id')
                ->where('order_headers.created_at', '>', Carbon::parse('1-08-2023'))->where('order_headers.order_status', '!=', 'Cancelled')
                ->groupBy('order_headers.id');
        }
        if (isset($inputData['wallet_status'])) {
            $country->where('wallet_status', $inputData['wallet_status'])->orderBy('updated_at', 'desc');
        }
        return $country->select('order_headers.*')->paginate($this->defaultLimit);
    }

    public function updateData($conditions, $updatedData)
    {
        return OrderHeader::where($conditions)->update($updatedData);
    }
}
