<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection , WithHeadings
{

    private  $start_date;
    private  $end_date;
    public function __construct($start_date , $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(["id","account_id","initial_password","nationality_id","full_name","email","stage","phone","bank_account_no","profile_photo","front_id_image","back_id_image","created_at"])->whereBetween('created_at',[$this->start_date, $this->end_date])->get();
    }

    public function headings() :array
    {
        return ["id","account_id","initial_password","nationality_id","full_name","email","stage","phone","bank_account_no","profile_photo","front_id_image","back_id_image","created_at"];
    }
}
