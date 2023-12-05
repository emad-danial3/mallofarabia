<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class UsersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
        '*.account_id' => 'required',
        '*.bank_account_no' => 'required',
        ])->validate();
        foreach ($rows as $row) {
            User::where([
                'account_id' => $row['account_id']
            ])->update(['has_credit_cart' => 1,'bank_account_no'=>$row['bank_account_no']]);
        }
    }
}
