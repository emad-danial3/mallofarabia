<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderUserExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
        //
        $condtions=[];
        if(isset($this->payment_status) && $this->payment_status !=''){
            $condtions=[['order_headers.payment_status','=',$this->payment_status]];
        }else{
            $condtions=[['order_headers.id','>',0]];
        }


        $OrderLines= DB::table('order_headers')
            ->join('users', 'order_headers.user_id', '=', 'users.id')
            ->join('user_addresses', 'order_headers.address_id', '=', 'user_addresses.id')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->join('areas', 'user_addresses.area_id', '=', 'areas.id')
            ->select(
                     'order_headers.id',
                            'order_headers.payment_code',
                            'order_headers.total_order',
                            'users.full_name',
                            'users.user_type',
                            'users.account_id',
                            'users.phone',
                            'users.telephone',
                            'users.email',
                            'users.address',
                            'cities.name_en',
                            'areas.region_en',
                             'user_addresses.floor_number as building_number',
                             'user_addresses.floor_number',
                             'user_addresses.apartment_number',
                             'user_addresses.landmark',
                            'users.nationality_id',
                            'users.user_type as order_type',
                            'order_headers.shipping_amount',
                            'order_headers.payment_status',
                            'order_headers.order_status',
                            'order_headers.shipping_date',
                            'order_headers.delivery_date',
                            'order_headers.wallet_status',

                            'order_headers.gift_id',
                            'order_headers.created_at'
            )
            ->orderBy('order_headers.created_at')
            ->where($condtions)
            ->whereBetween('order_headers.created_at',[$this->start_date, $this->end_date])
            ->get();


        return  $OrderLines;

    }


    public function headings(): array
    {
        return [
                        "Invoice Number",
                        "payment_code",
                        "total_order",
                        "User Name",
                        "User Type",
                        "User Serial Number",
                        "User phone",
                        "User landline number",
                        "User email",
                        "User Street",
                        "User City",
                        "User Area",
                        "User Building Number",
                        "User Floor Number",
                        "User Apartment Number",
                        "User Landmark",
                        "User NationalID",
                        "order_type",
                        "shipping_amount",
                        "payment_status",
                        "order_status",
                        "shipping_date",
                        "delivery_date",
                        "wallet_status",

                        "gift_category_id",
                        "Date",
        ];
    }
}
