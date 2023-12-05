<?php

namespace App\Exports;

use App\Models\UserCommission;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthCommissionsExport implements FromCollection, WithHeadings
{

    private $start_date;
    private $end_date;
    private $data;

    public function __construct($start_date, $end_date, $data)
    {
        $this->start_date = $start_date;
        $this->end_date   = $end_date;
        $this->data       = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $returned = array();
        foreach ($this->data as $row) {
            $exported['ID']                  = $row->id;
            $exported['User ID']             = $row->user->id;
            $exported['Nationality ID']      = $row->user->nationality_id;
            $exported['User Name']           = $row->user->full_name;
            $exported['Redeem Flag']         = $row->is_redeemed;
            $exported['Date Of Redeem']      = $row->redeem_date;
            $exported['Personal Order']      = $row->personal_order == '1' ? 'Yes' : 'no';
            $exported['Active Team Count']   = $row->active_team;
            $exported['g1 new Count']        = $row->g1_new;
            $exported['g1 new Sales']        = $row->g1_new_sales;
            $exported['Total g1 Sales']      = $row->total_g1_sales;
            $exported['Total g2 Sales']      = $row->total_g2_sales;
            $exported['Total Team Sales']    = $row->total_sales_po_g1_g2;
            $exported['UpLevel']             = $row->upLevel == '1' ? 'Yes' : 'no';
            $exported['Earn g1 New Sales']   = $row->e_g1_new_sales;
            $exported['Earn total g1 Sales'] = $row->e_total_g1_sales;
            $exported['Earn total g2 Sales'] = $row->e_total_g2_sales;
            $exported['Earn UpLevel Sales']  = $row->e_upLevel;
            $exported['Total Earnings']      = $row->total_earnings;
            $exported['Front ID Image']      = url(($row->user) ? $row->user->front_id_image : '');
            $exported['Back ID Image']       = url(($row->user) ? $row->user->back_id_image : '');
            $exported['Create AT']           = $row->created_at;
            $exported['Updated AT']          = $row->updated_at;
            $exported['PAID']                = $row->is_paid;
            array_push($returned, $exported);

        }

        return collect($returned);

    }

    public function headings(): array
    {
        return
            ['ID',
             'User ID',
             'Nationality ID',
             'User Name',
             'Redeem Flag',
             'Date Of Redeem',
             'Personal Order',
             'Active Team Count',
             'g1 new Count',
             'g1 new Sales',
             'Total g1 Sales',
             'Total g2 Sales',
             'Total Team Sales',
             'UpLevel',
             'Earn g1 New Sales',
             'Earn total g1 Sales',
             'Earn total g2 Sales',
             'Earn UpLevel Sales',
             'Total Earnings',
             'Front ID Image',
             'Back ID Image',
             'Create AT',
             'Updated AT',
             'PAID'
            ];
    }
//    public function collection()
//    {
//        dd( UserCommission::select([
//                                        "users.account_id"
//                                        ,"users.full_name","users.email","users.phone",
//                                        DB::raw('(CASE WHEN user_commissions.is_redeemed = 0 THEN "Not Redeemed" ELSE "Redeemed" END) AS is_user'),
//                                        "user_commissions.redeem_date",
//                                        DB::raw("SUM(user_commissions.commission) as count"),
//                                        "user_commissions.created_at",
//                                        "user_commissions.is_paid"
//                                        ])
//                                ->join('order_headers','order_headers.id','user_commissions.order_id')
//                                ->join('users','users.id','user_commissions.commission_by')
//                                ->havingBetween('user_commissions.created_at',[$this->start_date, $this->end_date])
//                                ->having('user_commissions.is_paid',1)
//                                ->groupBy('user_commissions.is_redeemed','users.account_id')
//                                ->get()
//        );
//    }
//
//    public function headings() :array
//    {
//        return ["account_id","nationality_id","full_name","email","phone","is_redeemed","redeem_date","commission"];
//    }
}
