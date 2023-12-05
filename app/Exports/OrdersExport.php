<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection , WithHeadings
{
    private  $start_date;
    private  $end_date;
    private  $payment_status;
    public function __construct($start_date , $end_date,$payment_status='')
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->payment_status = $payment_status;
    }

    public function collection()
    {
        $condtions=[];
        if(isset($this->payment_status) && $this->payment_status !=''){
            $condtions=[['order_headers.payment_status','=',$this->payment_status]];
        }else{
            $condtions=[['order_headers.id','>',0]];
        }
        $OrderLines= DB::table('order_lines')
            ->join('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->join('users', 'order_headers.user_id', '=', 'users.id')
            ->join('products', 'order_lines.product_id', '=', 'products.id')
            ->select('users.account_id','order_headers.id','products.oracle_short_code','order_lines.quantity','order_lines.price','products.price as price_before_discount' ,'order_lines.discount_rate' ,'order_headers.payment_code','order_lines.oracle_num','products.flag')
            ->orderBy('order_lines.oracle_num')
            ->where($condtions)
            ->whereBetween('order_headers.created_at',[$this->start_date, $this->end_date])
            ->get();
        return  $OrderLines;
    }

    public function headings(): array
    {
        return ["serial","invoice","item","quantity","price","price_before_discount","discount_rate","fawry code","oracle_num","flag"];
    }
}
