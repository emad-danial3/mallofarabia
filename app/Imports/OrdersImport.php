<?php

namespace App\Imports;

use App\Models\OrderHeader;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class OrdersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
        '*.order_id' => 'required',
        ])->validate();
        foreach ($rows as $row) {
            OrderHeader::where([
                'id' => $row['order_id'],
                'wallet_status' => 'cash'
            ])->update(['payment_status' => $row['payment_status'],'order_status' => $row['order_status']]);
        }
    }
}
